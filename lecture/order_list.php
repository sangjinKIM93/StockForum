<?php
session_start();
$uid = $_SESSION['id'];
//주문 내역 가져오기
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM order_list where userid = '$uid' AND state=0";
$result= mysqli_query($conn, $sql);

function changeFormat($var)
{
 if($var == 0){
     return '결제 완료';
 } else if($var == 1){
     return '결제 취소';
 }
}
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
    <!-- Navigation -->
  <?php include 'menubar_lecture.php'; ?>
  <br>
  <div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>제목</td>
                <td>강연일</td>
                <td>상태</td>
                <td>결제일</td> 
            </tr>
        </thead>
        <tbody>
            <?php 
            while($fetch = mysqli_fetch_array($result, MYSQLI_ASSOC)){ 
            $stateChanged = changeFormat($fetch['state']);    
            ?>
            <tr>
                <td><?=$fetch['title']?></td>
                <td><?=$fetch['lectureDay']?></td>
                <td><?=$stateChanged?></td>    
                <td><?=$fetch['created']?></td>  
            </tr>
            <?php } ?>
        </tbody>
    </table>
  </div>
  
    

  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>