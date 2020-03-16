<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/heroic-features.css" rel="stylesheet">
    <style>
        .radius{
            width:200px;
            height:200px;
            object-fit: cover;
            border-radius:50%;
        }
    </style>
</head>
<body>
    
    <?php include 'menubar.php'; ?>
    
    <div align="center">
        <div>
          <img class='radius'src="./img/man.jpg"> 
        </div><br>    
        <p>NAME : <?=$_SESSION["name"]?></p>
        <p>ID : <?=$_SESSION["id"]?></p>
        
        <button type="button" class="btn btn-primary" onclick="location.href='lecture/basket.php'">장바구니</button>
        <button type="button" class="btn btn-primary" onclick="location.href='lecture/order_list.php'">주문내역</button>
        <button type="button" class="btn btn-primary" onclick="location.href='lecture/my_lecture.php'">나의 강좌</button>
        <button type="button" class="btn btn-primary" onclick="location.href='logout.php'">로그아웃</button><br>
    </div>
    
     <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>