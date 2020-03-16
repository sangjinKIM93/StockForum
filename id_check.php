<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$id_check = $_POST['id_check'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$strsql = "SELECT * FROM user WHERE email=$id_check";
$result = mysqli_query($conn, $straql);  
$data = mysqli_fetch_array($result);
$num = mysqli_num_rows($data);

return $num;
?>