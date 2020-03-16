<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$con_num = $_POST['con_num'];
$content = $_POST['content'];
$uid = $_SESSION["name"];

echo $con_num.$content.$uid;

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO freeboard_reply
  (con_num, name, content, date)
  VALUES(
    $con_num,
    '$uid',
    '$content',
    NOW()
    )";
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '저장하는 과정에서 문제가 생겼습니다.';
    }else{
        echo '성공했습니다.';
        echo "<script>history.go(-1);</script>";
    }
?>