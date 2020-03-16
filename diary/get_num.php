<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$name = $_GET['name'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT num FROM current_stock where uid = '$uid' and name = '$name'";
$result = mysqli_query($conn, $sql);

$resultArray = array();
    while($fetch = mysqli_fetch_array($result)){
        $num = $fetch['num'];
        array_push($resultArray,array('num'=>$num));
    }
    
    echo json_encode($resultArray);
?>