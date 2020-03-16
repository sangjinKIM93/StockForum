<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $lectureDay = $_GET['lectureDay'];
    

    $sql_reply = "SELECT * FROM lectureboard where lectureDay='$lectureDay' ORDER BY idx DESC";
    $reply_data = mysqli_query($conn, $sql_reply);
    $resultArray = array();
    while($fetch = mysqli_fetch_array($reply_data)){
        $title = $fetch['title'];
        $content = $fetch['content'];
        $name = $fetch['name'];
        $created = $fetch['created'];
        $idx = $fetch['idx'];
        array_push($resultArray,array('title' => $title, 'content'=>$content, 'name'=>$name, 'created'=>$created, 'idx'=>$idx));
    }
    
    echo json_encode($resultArray);
?>