<?php
session_start();
$uid = $_SESSION['id'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql = "SELECT * FROM current_stock where num > 0 and uid='$uid'";
$result= mysqli_query($conn, $sql);

$resultArray = array();
    while($fetch = mysqli_fetch_array($result)){
        $name = $fetch['name'];
        array_push($resultArray,array('name'=>$name));
    }
    
    echo json_encode($resultArray);
?>