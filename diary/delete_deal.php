<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$idx = $_POST['del_idx'];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql_cs1 = "SELECT * FROM deal_list where idx='$idx'";
$result_cs1 = mysqli_query($conn, $sql_cs1);
$fetch = mysqli_fetch_array($result_cs1);

$state = $fetch['state'];
$name = $fetch['name'];
$num = $fetch['num'];
$priceAvg = $fetch['priceAvg'];
$totalAvg = $priceAvg*$num;
$total = $fetch['total'];

//1.deal_list에서 삭제
$sql = "
  DELETE
    FROM deal_list
    WHERE idx = $idx and uid='$uid'";

$result = mysqli_query($conn, $sql);

//2.current stock 처리
//state 1일 경우와 2일 경우 나눠서
if($state == '1'){
    $sql_cs = "
        UPDATE current_stock 
        SET
            num = num - $num,
            total = total - $total
        WHERE
            name = '$name' and uid='$uid'
            ";
    $result_cs = mysqli_query($conn, $sql_cs);

    //평균 가격 수정
    $sql_avg = "SELECT * FROM current_stock where name='$name' and uid='$uid'";
    $result_avg = mysqli_query($conn, $sql_avg);
    $fetch_avg = mysqli_fetch_array($result_avg);
    if($fetch_avg['num'] == 0){
        $priceAvg = 0;
    }else{
        $priceAvg = round($fetch_avg['total']/$fetch_avg['num']);
    }
    
    $sql_avg2 = "
        UPDATE current_stock 
        SET
            priceAvg = $priceAvg
        WHERE
            name = '$name' and uid='$uid'
            ";
    $result_avg2 = mysqli_query($conn, $sql_avg2);

} else {
    //매도의 역 == '+'
    $sql_cs = "
        UPDATE current_stock 
        SET
            num = num + $num,
            total = total + $totalAvg
        WHERE
            name = '$name' and uid='$uid'
            ";
    $result_cs = mysqli_query($conn, $sql_cs);

}


if($result === true && $result_cs === true){
    echo 'success';
    
}else{
    echo '수정하는 과정에서 문제가 생겼습니다.';
    //echo $result;
    echo $result_cs;
}
?>