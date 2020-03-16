<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$con_idx = $_POST['con_idx'];
$content = $_POST['content'];
$uid = $_SESSION["name"];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO freeboard_rereply
  (con_idx, name, content, created)
  VALUES(
    $con_idx,
    '$uid',
    '$content',
    NOW()   
    )";
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '저장하는 과정에서 문제가 생겼습니다.';
    }else{
        echo 'success';
    }
?>