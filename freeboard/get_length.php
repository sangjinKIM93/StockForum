<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$idx = $_GET['idx'];
$idx_checklength = $idx;
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql_reply = "SELECT * FROM freeboard_rereply where con_idx=$idx_checklength";
$reply_data = mysqli_query($conn, $sql_reply);
$count = mysqli_num_rows($reply_data);

    if($count > 0){
        echo 'success';   
    }else{
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }

?>