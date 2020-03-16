<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$num = $_POST['num'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  DELETE
    FROM freeboard
    WHERE num = $num ";

    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
        echo $num;
    }else{
        echo '성공했습니다.';
        header('Location: http://localhost/template2/freeboard/free-board.php');
    }
?>