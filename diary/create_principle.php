<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$content = $_POST['content'];
$uid = $_SESSION["id"];


$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO principle
  (content, uid, created, position, reference)
  VALUES(
    '$content',
    '$uid',
    NOW(),
    100,
    'null'
    )";
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '저장하는 과정에서 문제가 생겼습니다.';
    }else{
        echo 'success';
        //echo "<script>history.go(-1);</script>";
    }



?>