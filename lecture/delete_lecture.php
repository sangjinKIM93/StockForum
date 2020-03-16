<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$idx = $_POST['idx'];
$imageFile = $_POST['imageFile'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  
    UPDATE lectureboard
    SET
        deleted = 1
    WHERE
        idx = '$idx' ";

    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
        
    }else{
        if($imageFile != "placeholder.jpg"){
            unlink("./file_uploads/".$imageFile);
        }   
        echo '성공했습니다. 새로고침 버튼을 눌러 반영 여부를 확인해주세요.';
        
    }
?>