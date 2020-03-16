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

// <!-- 페이징을 위한 변수들 설정 -->
$search_word = $_GET['search_word'];
$field = $_GET['field'];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql_reply = "SELECT * FROM lectureboard where $field like '%$search_word%'";
$resultPaging = mysqli_query($conn, $sql_reply);
$totalArticle= mysqli_num_rows($resultPaging);

$page = ($_GET['page'])?$_GET['page']:1;
$list = 4;
$block = 3;

$pageNum = ceil($totalArticle/$list);
$blockNum = ceil($pageNum/$block);
$nowBlock = ceil($page/$block);

$start_page = (($nowBlock-1)*$block)+1;
if($start_page <= 1){
  $start_page = 1;
}
$end_page = $nowBlock*$block;
if($pageNum <= $end_page){
  $end_page = $pageNum;
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

<div class="container">
  <h3 style="text-decoration:underline; text-underline-position:under; text-align:center">퀀트/주식 강연</h3><br>
  <!-- 글 검색 -->
    <form method="get">
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
    <button type="button" name="date_rank" class="btn btn-outline-primary btn-sm" onclick="location.href='calendar.php'">달력으로 보기</button>
    <button type="button" name="hit_rank" class="btn btn-outline-primary btn-sm">목록으로 보기</button> 
  </div><br>

  <?php
    $start_point = ($page-1)*$list;
    //이미지 가져오기
    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $sql_lec = "SELECT * FROM lectureboard where $field like '%$search_word%' ORDER BY idx DESC LIMIT $start_point,$list";
    //$sql_img = "SELECT * FROM lectureboard where deleted = '0' order by idx DESC Limit 4";
    $result_img= mysqli_query($conn, $sql_lec);
    //$users = mysqli_fetch_array($result_img);
    $list_lec = mysqli_num_rows($result_img);
    ?>

  <div class="row d-flex flex-wrap" id="lectureList"  >
    <?php if($list_lec == 0){
        echo '<h4 style="text-align:center">검색결과가 없습니다.</h3>';
    } else if($list_lec< $list){
        for($i=1; $i<=$list_lec; $i++){
            $user = mysqli_fetch_array($result_img);
        ?>
    
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
        }
        
    }else {
        for($i=1; $i<=$list; $i++){
            $user = mysqli_fetch_array($result_img);
            ?>
        
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
        }
    }
    ?>
    
  </div><br>
  
  <!-- 페이징 버튼. 부트스트랩 활용 -->
  <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="search_lec.php?field=<?=$field?>&search_word=<?=$search_word?>&page=<?=$start_page-1?>">이전</a>
        </li>
        <?php
        for($p=$start_page; $p<=$end_page; $p++){
        ?>
        <li class="page-item"><a class="page-link" href="search_lec.php?field=<?=$field?>&search_word=<?=$search_word?>&page=<?=$p?>"><?=$p?></a></li>
        <?php
        }
        ?>
        <li class="page-item">
          <a class="page-link" href="search_lec.php?field=<?=$field?>&search_word=<?=$search_word?>&page=<?=$end_page+1?>">다음</a>
        </li>
      </ul>
    </nav>
  
</div>

<script>

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
