<?php
session_start();
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO freeboard
  (title, content, name, uid, created, modified, deleted, hits, likes)
  VALUES(
    '{$_POST['title']}',
    '{$_POST['content']}',
    '{$_SESSION["name"]}',
    '{$_SESSION["id"]}', 
    NOW(),
    NULL,
    NULL,
    0,
    0
    )";
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '저장하는 과정에서 문제가 생겼습니다.';
    }else{
        echo '성공했습니다.';
        header('Location: http://localhost/template2/freeboard/free-board.php');
    }

?>