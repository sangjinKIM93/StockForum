<?php
//날짜 변환
function display_datetime($datetime = '')
{
    if (empty($datetime)) {
        return false;
    }

    $diff = time() - strtotime($datetime);

    $s = 60; //1분 = 60초
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $y = $d * 3; //1년 = 1일 * 3일

    if ($diff < $s) {
        $result = $diff . '초전';
    } elseif ($h > $diff && $diff >= $s) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff && $diff >= $h) {
        $result = round($diff/$h) . '시간전';
    } elseif ($y > $diff && $diff >= $d) {
        $result = round($diff/$d) . '일전';
    } else {
        $result = date('Y.m.d.', strtotime($datetime));
    }

    return $result;
}

error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];

//페이징된 데이터만 가져오기 위한 변수들

$list = 5;
$page = $_GET['page'];
$start_point = ($page-1)*$list;

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql_reply = "SELECT * FROM deal_list where uid ='$uid' ORDER BY created DESC LIMIT $start_point,$list";
$reply_data = mysqli_query($conn, $sql_reply);
$resultArray = array();
while($fetch = mysqli_fetch_array($reply_data)){
    
    $name = $fetch['name'];
    $num = $fetch['num'];
    $price = $fetch['price'];
    $total = $fetch['total'];
    $created = $fetch['created'];
    $filtered_created = display_datetime($created);
    $state = $fetch['state'];
    $idx = $fetch['idx'];
    array_push($resultArray,array('name'=>$name, 'num'=>$num, 'price'=>$price, 'total'=>$total, 'created'=>$filtered_created, 'state'=>$state, 'idx'=>$idx));
}

echo json_encode($resultArray);
?>