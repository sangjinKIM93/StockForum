<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$content = $_POST['content'];
$idx = $_POST['con_idx'];
$uid = $_SESSION["name"];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO freeboard_reply
  (con_num, name, content, created)
  VALUES(
    $idx,
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