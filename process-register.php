<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO user
  (email, password, name, created)
  VALUES(
    '{$_POST['email']}',
    '{$_POST['pwd']}',
    '{$_POST['name']}',
    NOW()
    )";
// if($_POST['password1'] != $_POST['password2']){
//   echo"<script>alert('check your password.');history.back();</script>";
//   exit;
// } else {
//   echo"<script>alert('Success to register! Let's login.');</script>";
  $result = mysqli_query($conn, $sql);
  header("Location:http://localhost/template2/login.php");
// }


?>
