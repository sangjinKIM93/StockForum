<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$idx = $_POST['idx'];
$memoIdx = $_POST['memoIdx'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT reference from principle where idx = $idx";
$result = mysqli_query($conn, $sql);
$fetch = mysqli_fetch_array($result);

//reference 받고 추가해서 다시 저장
$pre_Array = $fetch['reference'];

if($pre_Array == "null"){    //기존 reference가 없는 경우
    $sqlUpdate = "UPDATE principle SET reference=JSON_ARRAY($memoIdx) where idx=$idx and uid='$uid'";
    $resultEmpty = mysqli_query($conn, $sqlUpdate);
}else{
    
    $pre_Array =json_decode($pre_Array);
    array_push($pre_Array, "$memoIdx");       //array에 추가
    var_dump($pre_Array);
    $pre_Array = implode(',', $pre_Array);
    $sqlUpdate2 = "UPDATE principle SET reference=JSON_ARRAY($pre_Array) where idx=$idx and uid='$uid'";
    $resultEmpty = mysqli_query($conn, $sqlUpdate2);
}

    if($resultEmpty === false){
        echo '저장하는 과정에서 문제가 생겼습니다.';
    }else{
        echo 'success';
    }
?>