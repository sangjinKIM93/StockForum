<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$idx = $_GET['idx'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM order_list where lec_idx = $idx";
$result = mysqli_query($conn, $sql);
$fetch =  mysqli_fetch_all($result, MYSQLI_ASSOC);
$row = mysqli_num_rows($result);

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
                <td>신청자 닉네임</td>
                <td>신청자 id</td>
                <td>신청일</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($fetch as $target): ?>
            <tr>
                <td><?=$target['title']?></td>
                <td><?=$target['name']?></td>
                <td><?=$target['userid']?></td>
                <td><?=$target['created']?></td>
            </tr>
        <?php endforeach; ?> 
            
        </tbody>
    </table>
    총 인원 :&ensp;<?=$row?>
  </div>
  
    
  <script>
  
  </script>
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>