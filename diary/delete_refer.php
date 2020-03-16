<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$princlipleIdx = $_POST['princlipleIdx'];
$memoIdx = $_POST['memoIdx'];
//principle 가져오기
$sqlSel = "SELECT reference from principle where idx = $princlipleIdx";
$resultSel = mysqli_query($conn, $sqlSel);
$fetch = mysqli_fetch_array($resultSel);
$refer = $fetch['reference'];

//refer 데이터 수정하기. refer데이터 중 memoIdx를 찾아 제거
$refer = json_decode($refer);    //array로 변경
$refer = array_diff($refer, array($memoIdx));
$refer = array_values($refer);
$refer = implode(',', $refer);

//자료가 모두 사라지면 메모 표시도 사라지게 하기 위함 ->null 넣어주기.
if($refer == ""){
    $sql = "
    UPDATE
        principle
        SET reference = 'null'
        where idx = $princlipleIdx and uid='$uid' ";
} else {
    $sql = "
    UPDATE
        principle
        SET reference = JSON_ARRAY($refer)
        where idx = $princlipleIdx and uid='$uid' ";
}

    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo 'success';
    }
?>