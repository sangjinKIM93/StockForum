<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$name = $_GET['name'];

//종목 거래 내역 가져오기
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM deal_list where name = '$name' and uid='$uid'";
$result = mysqli_query($conn, $sql);
$fetch =  mysqli_fetch_all($result, MYSQLI_ASSOC);
$row = mysqli_num_rows($result);

//종목 메모 리스트 가져오기
$sqlMemo = "SELECT * FROM diary_list where uid='$uid' AND stockName='$name' order by idx DESC";
$resultMemo= mysqli_query($conn, $sqlMemo);
$fetchMemo =  mysqli_fetch_all($resultMemo, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/heroic-features.css" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

  <br>
  <div class="container">
    <h5>매도/매수 리스트</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>구분</td>
                <td>종목명</td>
                <td>수량</td>
                <td>가격</td>
                <td>총액</td>
                <td>날짜</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($fetch as $target): ?>
            <tr>
            <?php if($target['state']==1){
                $state = "매수";
            }else{
                $state = "매도";
            }
                ?>
                <td><?=$state?></td>
                <td><?=$target['name']?></td>
                <td><?=$target['num']?></td>
                <td><?=number_format($target['price'])?></td>
                <td><?=number_format($target['total'])?></td>
                <td><?=$target['created']?></td>
            </tr>
        <?php endforeach; ?> 
        </tbody>
    </table>
    <br><br>
    <h5>메모 리스트</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <td>구분</td>
                <td>제목</td>
                <td>종목명</td>
                <td>날짜</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($fetchMemo as $memo): ?>
            <tr style="cursor:pointer" onclick="popup('+<?=$memo['idx']?>+')">
            <?php if($memo['state']==1){ ?>
                <td><p style="color:red">매수</p></td>
            <?php }else{ ?>
                <td><p style="color:blue">매도</p></td>
            <?php } ?>
                
                <td><?=$memo['title']?></td>
                <td><?=$memo['stockName']?></td>
                <td><?=$memo['created']?></td>
            </tr>
        <?php endforeach; ?> 
        </tbody>

    </table>
  </div>
  
    
  <script>
  function popup(idx){
      var url = "http://localhost/template2/diary/memo_view.php?idx="+idx;
      var name = "memoWrite";
      var option = "width = 650, height = 500, top=80, left=550, location=no";
      window.open(url, name, option);
    }
  </script>
  
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>