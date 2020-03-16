<?php
//게시글 몇분전 표시
function display_datetime($datetime = '')
{
    if (empty($datetime)) {
        return false;
    }

    $diff = time() - strtotime($datetime);

    $s = 60; //1분 = 60초
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $y = $d * 3; //1년 = 1일 * 3일

    if ($diff < $s) {
        $result = $diff . '초전';
    } elseif ($h > $diff && $diff >= $s) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff && $diff >= $h) {
        $result = round($diff/$h) . '시간전';
    } elseif ($y > $diff && $diff >= $d) {
        $result = round($diff/$d) . '일전';
    } else {
    	$result = date('Y.m.d', strtotime($datetime));
    }

    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Quant-Forum</title>
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/heroic-features.css" rel="stylesheet">
  <style>
    #grid-content{
      border:1px solid grey;
      display:grid;
      grid-template-columns: 5fr 1fr;
    }
    #titleLine{
      line-height: 1em;
      max-height: 2.5em;
      display: -webkit-box;
      overflow: hidden;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
    }
    
  </style>
</head>
<body>
<!-- Navigation -->
<?php include 'menubar_lecture.php'; ?>

<?php
//이미지 가져오기
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql_img = "SELECT * FROM lectureboard where deleted = '0' order by idx DESC Limit 4";
$result_img= mysqli_query($conn, $sql_img);
$users = mysqli_fetch_all($result_img, MYSQLI_ASSOC);
?>

<div class="container">
  <h3 style="text-decoration:underline; text-underline-position:under; text-align:center">퀀트/주식 강연</h3><br>
  <!-- 글 검색 -->
    <form action="search_lec.php" method="get">
        <div class="d-flex justify-content-center">
          <div>
            <select name="field" class="form-control" id="">
                  <option value="title">제목</option>
                  <option value="content">내용</option>
                  <option value="name">글쓴이</option>
            </select>
          </div>
          <div>
            <input type="text" name="search_word" class="form-control" placeholder="search">
          </div>
          <div>
            <input type="submit" class="btn btn-primary" id="">
          </div>
        </div>
    </form>
  
  <!-- 글쓰기 버튼 -->
  <?php
    if(isset($_SESSION["id"])) {
    ?>
      <button type="button" class="btn btn-primary" style="float:right" onclick="location.href='lecture_write.php'">강의 등록</button>
    <?php
    } else {
    ?>
      <p style="float:right">강연 등록은 로그인 후 가능합니다.</p>
    <?php
    }  
  ?>

  <div>
    <button type="button" name="date_rank" class="btn btn-outline-primary btn-sm" onclick="location.href='calendar.php'" style="display:none">달력으로 보기</button>
    <button type="button" name="hit_rank" class="btn btn-outline-primary btn-sm" style="display:none">목록으로 보기</button> 
  </div><br><br>

  <div class="row d-flex flex-wrap" id="lectureList"  >
    <?php foreach($users as $user): ?>
    <div class="card btn btn-outline-light text-dark" onclick="popup(<?=$user['idx']?>)" style="width:250px; height:390px; margin:17px">
      <img class="card-img-top" src="file_uploads/<?=$user['imageFile']?>" alt="Card image cap" style="width:100%; height:70%"> 
        <br><p id="titleLine"><?=$user['title']?></p>
        <?php if($user['finished'] == 'on'){ ?>  
          <p style="color:red; border:1px solid red;">모집마감!</p>       
        <?php }else{ ?>
          <?=$user['lectureDay']?>
        <?php } ?>

    </div>
    <?php
      //더보기를 위한 idx 
      $last_idx = $user['idx'];
    ?>
    <?php endforeach; ?> 
  </div><br>
  <div class="text-center">
    <button type="button" id="moreBtn" class="btn btn-outline-primary" onclick="getMore(<?=$last_idx?>)" >더보기</button>
  </div><br><br>
  
</div>

<script>
function getMore(start_point){
        
        //$("#board_num").val(); // 아니 board_num이 어딨어? 뭐 이거는 mysql로 받아오면 되니까 일단 18번으로 가자

        console.log("getmore()");
        console.log(start_point);
            
        $.getJSON("getmore.php?start_point="+start_point, function(data){
            console.log(data);

            //4개로 딱 맞아떨어졌을때 즉,데이터가 없을떄 버튼 숨기기
            if(data==""){
              $("#moreBtn").css("display", "none");
            }
            
            //$("."+idx_num+" *").remove();
            $(data).each(function(){

            if(this.checked == 'on'){
              var date = '<p style="color:red; border:1px solid red;">모집마감!</p>';
            }else{
              var date = this.lectureDay;
            }
            
            var contentModified = '<div class="card btn btn-outline-light text-dark" onclick="popup('+this.idx+')" style="width:250px; height:390px; margin:17px"><img class="card-img-top" src="file_uploads/'+this.imageFile+'" alt="Card image cap" style="width:100%; height:70%"><br><p id="titleLine">'+this.title+'</p>'+date+'</div>';

            var content = '<div class="card btn btn-outline-light text-dark" onclick="popup('+this.idx+')" style="width:16rem; height:20rem; margin:14px"><img class="card-img-top" src="file_uploads/'+this.imageFile+'" alt="Card image cap" style="height:14rem"><div class="card-body"><p class="card-text" style="text-align:center">'+this.title+'<br>'+this.lectureDay+'</p></div></div>';
            $("#lectureList").append(contentModified);

            //더이상 볼 것이 없을때 버튼 숨기기
            if(this.length < 4){
              $("#moreBtn").css("display", "none");
            } else {
              //버튼 변수 변경
              $("#moreBtn").removeAttr("onclick");
              $("#moreBtn").attr("onclick", 'getMore('+this.idx+')');
            }

            });    
        });
    }

    function popup(idx){
      var url = "lecture_view.php?idx="+idx;
      var name = "popup.test";
      var option = "width = 650, height = 600, top=50, left=350, location=no";
      window.open(url, name, option);
    }
</script>
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
