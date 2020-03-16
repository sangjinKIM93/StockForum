<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$idx = $_POST['idx'];
$url = 'Location: http://localhost/template2/diary/memo_view.php?idx='.$idx;
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  UPDATE diary_list
    SET
        title = '$title',
        content = '$content'
    WHERE
        idx = '$idx' and uid='$uid'";
    
$result = mysqli_query($conn, $sql);
    if($result === false){
        echo $result;
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo '성공했습니다.';
        header($url);
    }
?>