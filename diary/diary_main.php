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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
</head>
<body>
<!-- Navigation -->
<?php include 'menubar_diary.php'; ?>
<div class="container">
<!-- 초기 설정 버튼 -->
<!-- <button type="button" class="btn btn-primary" onclick="location.href=''">초기 설정</button><br><br> -->

<!-- 초기 설정 -->
<form action="process_diary.php" method="POST" id="form_initial">
  <div class="form-row">
    <div class="form-group col">
      <label for="inputEmail4">종목 이름</label>
      <input type="text" class="form-control" name="name" placeholder="이름">
    </div>
    <div class="form-group col-2">
      <label for="inputPassword4">수량</label>
      <input type="text" class="form-control" name="num" placeholder="수량">
    </div>
    <div class="form-group col">
      <label for="inputPassword4">매수 가격</label>
      <input type="text" class="form-control" name="price" placeholder="가격">
    </div>
    <div class="form-group col-1">
      <label for="inputPassword4">&ensp;</label>
      <input type="submit" class="form-control btn btn-primary" value="제출" placeholder="Password" onclick="add_initial(); return false;">
    </div>
  </div>
</form><br>
<h4>나의 포트폴리오</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>종목명</td>
            <td>매수 가격</td>
            <td>수량</td>
            <td>날짜</td>
            <td>삭제</td>
        </tr>
    </thead>
    <tbody class="initialList">
        
    </tbody>
</table><br>

<!-- 투자 일기 -->
<button class="btn btn-primary" style="float:right" onclick="location.href='diary_write.php'">매도 쓰기</button>
<button class="btn btn-primary" style="float:right" onclick="location.href='diary_write.php'">매수 일기</button>
<h5>매수/매도 내역</h5><br>
<table class="table table-hover">
    <thead>
        <tr>
            <td>구분</td>
            <td>종목</td>
            <td>제목</td>
            <td>날짜</td>
        </tr>
    </thead>
    <tbody class="diaryList">
        <tr>
            <td>추가 매수</td>
            <td>상성전자</td>
            <td>삼성전자를 추가 매수했다.</td>
            <td>2019.2.24</td>
        </tr>
    </tbody>
</table><br>

</div>



<script>
    $(document).ready(function(){
        getInitialList();
    });

    function add_initial(){
        var formData = $('#form_initial').serialize();
        console.log(formData);
        $.ajax({
            type: 'POST',
            url : 'process_diary.php',
            data : formData,
            success : function(response){
                if(response=='success'){
                    console.log('ajax success!');
                    getInitialList();
                }
            }
        });
    }

    function delete_initial(delIdx){
        var form_var = '#formDel'+delIdx;
        var formData2 = $(form_var).serialize();
        console.log(formData2);
        $.ajax({
            type: 'POST',
            url : 'delete_initial.php',
            data : formData2,
            success : function(response){
                if(response=='success'){
                    getInitialList();
                }
            }
        });
    }

    function getInitialList(){
        $.getJSON("initial_list.php", function(data){
            console.log('getinitailList()');
            console.log(data);
            $(".initialList *").remove();
            $(data).each(function(){
                var initial_delete = '<td><form id="formDel'+this.idx+'" action="delete_initial.php" method="post"><input type="hidden" name="idx" value="'+this.idx+'"><input type="submit" value="삭제" onclick="delete_initial('+this.idx+'); return false;"></form></td>';
                var initialList = '<tr><td>'+this.name+'</td><td>'+this.price+'</td><td>'+this.num+'</td><td>'+this.created+'</td>'+initial_delete+'</tr>';
                $(".initialList").append(initialList);
                
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
