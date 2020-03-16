<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$idx = $_POST['idx'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  DELETE
    FROM freeboard_rereply
    WHERE idx = $idx ";

    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo "<script>history.go(-1);</script>";
    }
?>