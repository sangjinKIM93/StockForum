<?php

$processList = $_POST['list'];
$filteredList = implode(",", $processList);

//echo $processList[0];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM lectureboard WHERE idx IN ($filteredList)";
$result = mysqli_query($conn, $sql);

$resultArray = array();
while($fetch = mysqli_fetch_array($result)){
    $title = $fetch['title'];
    $lectureDay = $fetch['lectureDay'];
    $price = $fetch['price'];
    $idxTarget = $fetch['idx'];
    $name = $fetch['name'];
    $uid = $fetch['uid'];
    array_push($resultArray,array('title'=>$title, 'lectureDay'=>$lectureDay, 'price'=>$price, 'idx'=>$idxTarget, 'name'=>$name, 'uid'=>$uid));
}

echo json_encode($resultArray);

?>