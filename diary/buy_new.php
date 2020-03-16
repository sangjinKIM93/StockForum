<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$name = $_POST['name'];
$num = $_POST['num'];
$price = $_POST['price'];
$state = $_POST['state'];
$stockNum = $_POST['stockNum'];

//날짜 처리. 그리고 꼭 따옴표를 붙여줘야해...
$day = $_POST['day'];
$dayT = strtotime($day);
$date = date('Y-m-d H:i:s', $dayT);

$total = $num*$price;
$avg = round($total/$num);

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql = "
    INSERT INTO deal_list
    (name, num, price, priceAvg, total, created, uid, uName, state)
    VALUES(
        '$name',
        $num,
        $price,
        0,
        $total,
        '$date',
        '{$_SESSION["id"]}',
        '{$_SESSION["name"]}',
        $state
        )";
$result = mysqli_query($conn, $sql);

//자 여기서 current-stock을 건드려보자.
//같은 이름이 있을 경우 update , 없을 경우 insert
$sql_cs = "SELECT * FROM current_stock where name='$name' and uid='$uid'";
$result_cs = mysqli_query($conn, $sql_cs);
$fetch = mysqli_fetch_array($result_cs);
$row = mysqli_num_rows($result_cs);
if($row == 0){
    $sql_cs1 = "
    INSERT INTO current_stock
    (stockNum, name, num, price, priceAvg, total, created, uid, uName)
    VALUES(
        '$stockNum',
        '$name',
        $num,
        $price,
        $avg,
        $total,
        '$date',
        '{$_SESSION["id"]}',
        '{$_SESSION["name"]}'
        )";
    $result_cs1 = mysqli_query($conn, $sql_cs1);
} else {
    if($fetch['num']==0){

        $sql_cs2 = "
        UPDATE current_stock 
        SET
            num = $num,
            price = $price,
            priceAvg = $avg,
            total = $total
        WHERE
            name = '$name' and uid='$uid'
            ";
        $result_cs2 = mysqli_query($conn, $sql_cs2);

    } else{
        $sql_cs3 = "
        UPDATE current_stock 
        SET
            num = num + $num,
            total = total + $total
        WHERE
            name = '$name' and uid='$uid'
            ";
        $result_cs3 = mysqli_query($conn, $sql_cs3);

        //평균 가격 수정
        $sql_avg = "SELECT * FROM current_stock where name='$name' and uid='$uid'";
        $result_avg = mysqli_query($conn, $sql_avg);
        $fetch_avg = mysqli_fetch_array($result_avg);
        $priceAvg = round($fetch_avg['total']/$fetch_avg['num']);

        $sql_avg2 = "
            UPDATE current_stock 
            SET
                priceAvg = $priceAvg
            WHERE
                name = '$name' and uid='$uid'
                ";
        $result_avg2 = mysqli_query($conn, $sql_avg2);
    }
}


if($result === false){
    echo '수정하는 과정에서 문제가 생겼습니다.';
}else{
    echo 'success';
}

?>