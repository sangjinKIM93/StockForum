<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

$title = $_POST['title'];
$content = $_POST['content'];
$num = $_POST['num'];
$url = 'Location: http://localhost/template2/freeboard/view.php?num='.$num;
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  UPDATE freeboard
    SET
        title = '$title',
        content = '$content',
        modified = NOW()
    WHERE
        num = '$num' ";
    
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo '성공했습니다.';
        header($url);
    }
?>