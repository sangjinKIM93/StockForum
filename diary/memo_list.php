<?php
$list = 5;
$page = $_GET['page'];
$start_point = ($page-1)*$list;

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
session_start();
$uid = $_SESSION['id'];
$sql = "SELECT * FROM diary_list where uid='$uid' order by idx DESC LIMIT $start_point,$list";
$result= mysqli_query($conn, $sql);

$resultArray = array();
while($fetch = mysqli_fetch_array($result)){
    $title = $fetch['title'];
    $content = $fetch['content'];
    $state = $fetch['state'];
    $created = $fetch['created'];
    $idx = $fetch['idx'];
    $deal_idx = $fetch['deal_idx'];
    $name = $fetch['stockName'];
    
    array_push($resultArray,array('name'=>$name, 'title'=>$title, 'content'=>$content, 'state'=>$state, 'created'=>$created, 'idx'=>$idx));
}

echo json_encode($resultArray);
?>