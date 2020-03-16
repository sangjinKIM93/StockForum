<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
session_start();
$userid = $_SESSION['id'];

$sql_basket = "SELECT * FROM lecture_basket WHERE userid='$userid' AND state=0";
$basket_data = mysqli_query($conn, $sql_basket);

$resultArray = array();
while($fetch = mysqli_fetch_array($basket_data)){
    $idx = $fetch['lec_idx'];

    // lec_idx를 기반으로 각종 자료들 가져오기
    $sql_target = "SELECT * FROM lectureboard where idx=$idx";
    $target_data = mysqli_query($conn, $sql_target);
    while($target = mysqli_fetch_array($target_data)){
    $title = $target['title'];
    $lectureDay = $target['lectureDay'];
    $price = $target['price'];
    $idxTarget = $target['idx'];
    array_push($resultArray,array('title'=>$title, 'lectureDay'=>$lectureDay, 'price'=>$price, 'idx'=>$idxTarget));
}

}

echo json_encode($resultArray);
?>