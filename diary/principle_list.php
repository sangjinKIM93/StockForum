<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();
    $uid = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

    $sql_reply = "SELECT * FROM principle where uid = '$uid' ORDER BY position";
    $reply_data = mysqli_query($conn, $sql_reply);
    $resultArray = array();
    while($fetch = mysqli_fetch_array($reply_data)){
        $content = $fetch['content'];
        $idx = $fetch['idx'];
        $reference = json_decode($fetch['reference']);
        // $reference = implode(',', $reference);
        array_push($resultArray,array('content'=>$content, 'idx'=>$idx, 'reference'=>$reference));
    }
    
    echo json_encode($resultArray);
?>