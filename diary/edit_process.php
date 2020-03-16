<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$idx = $_POST['idx'];
$content = $_POST['content'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  UPDATE principle
    SET
        content = '$content',
        created = NOW()
    WHERE
        idx = $idx and uid='$uid'";
    
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo 'success';
    }
?>