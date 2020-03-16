<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$name = $_POST['name'];
$num = $_POST['num'];
$price = $_POST['price'];
$state = $_POST['state'];
$total = $num*$price;

$day = $_POST['day'];
$dayT = strtotime($day);
$date = date('Y-m-d H:i:s', $dayT);

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql_sc = "SELECT * FROM current_stock where name='$name' and uid='$uid'";
$result_cs = mysqli_query($conn, $sql_sc);
$fetch_avg = mysqli_fetch_array($result_cs);
$priceAvg = $fetch_avg['priceAvg'];
$totalAvg = $priceAvg*$num;

$sql = "
    INSERT INTO deal_list
    (name, num, price, priceAvg, total, created, uid, uName, state)
    VALUES(
        '$name',
        $num,
        $price,
        $priceAvg,
        $total,
        '$date',
        '{$_SESSION["id"]}',
        '{$_SESSION["name"]}',
        $state
        )";
$result = mysqli_query($conn, $sql);

$sql_cs2 = "
    UPDATE current_stock 
    SET
        num = num - $num,
        total = total - $totalAvg
    WHERE
        name = '$name' and uid='$uid'
        ";
$result_cs2 = mysqli_query($conn, $sql_cs2);

if($result === false){
    echo '수정하는 과정에서 문제가 생겼습니다.';
}else{
    echo 'success';
}

?>