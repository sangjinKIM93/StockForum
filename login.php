<?php
 if(isset($_COOKIE["id"])){
   $cookie_id = $_COOKIE["id"];
 }else {
   $cookie_id = "";
 }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Heroic Features - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/heroic-features.css" rel="stylesheet">
  <style media="screen">
  #login{
     margin: auto;
     width: 50%;
     padding: 10px;
     text-align: center;
  }

  </style>
</head>

<body>
  <!-- Navigation -->
  <?php include 'menubar.php'; ?>
  <br><br>

  <!-- lohin form -->
  <div class="container py-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div id="login">
        <h1><a href="index.html">Quant Forum</a></h1><br>
        <form action="login-get.php" method="post">
            <p><input type="text" name="id" placeholder="id" required></p>
            <p><input type="password" name="password" placeholder="password" required></p>
            <p align="left"><input type="checkbox" name="id_ck"> remember-ID</p>
            <p><input type="submit" value="login" class="btn btn-primary" style="height:40px; width:200px"></p>
            <a href="register.php">Register</a>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
