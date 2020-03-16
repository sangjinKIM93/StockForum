<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];

//종목 거래 내역 가져오기
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM current_stock where uid = '$uid'";
$result = mysqli_query($conn, $sql);
$fetch =  mysqli_fetch_array($result);


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
    <h5>모든 종목 리스트</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>종목명</td>
                <td>수량</td>
                <td>상세정보</td>
            </tr>
        </thead>
        <tbody>
        <?php while($fetch =  mysqli_fetch_array($result)){ ?>
            <tr>
                <td><?=$fetch['name']?></td>
                <td><?=$fetch['num']?></td>
                <td><button class="btn btn-secondary" onclick="popup('<?=$fetch['name']?>')">상세내역</button></td>
            </tr>
        <?php } ?> 
        </tbody>
    </table>
    <br><br>
    
  </div>
  
    
  <script>
  function popup(name){
      var url = "http://localhost/template2/diary/target_detail.php?name="+name;
      var name = "target_detail";
      var option = "width = 650, height = 500, top=80, left=550, location=no";
      window.open(url, name, option);
    }
  </script>
  
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>