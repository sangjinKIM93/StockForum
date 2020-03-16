<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$uid = $_SESSION['id'];
$list_arr = $_POST['list_arr'];

$position = 1;
foreach($list_arr as $list){
    mysqli_query($conn, "UPDATE principle SET position=$position where idx=$list and uid='$uid'");
    $position ++;
}
    
    if($position == 1){
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo 'success';
    }
?>