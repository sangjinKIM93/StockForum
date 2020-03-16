<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
$lec_idx = $_POST['idx'];
$title = $_POST['title'];
$lectureDay = $_POST['lectureDay'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO lecture_basket
  (title, lectureDay, userid, name, lec_idx, created, state)
  VALUES(
    '$title',
    '$lectureDay',
    '{$_SESSION["id"]}', 
    '{$_SESSION["name"]}',
    $lec_idx,
    NOW(),
    0
    )";
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '저장하는 과정에서 문제가 생겼습니다.';
        
    }else{
        echo "<script>history.back();</script>";
    }

?>



