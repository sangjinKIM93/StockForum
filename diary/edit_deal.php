<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$idx = $_POST['idx'];

//날짜 처리. 그리고 꼭 따옴표를 붙여줘야해...
$day = $_POST['day'];
$dayT = strtotime($day);
$date = date('Y-m-d H:i:s', $dayT);

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

//기존 자료 삭제
    $sql_cs1 = "SELECT * FROM deal_list where idx='$idx' and uid='$uid'";
    $result_cs1 = mysqli_query($conn, $sql_cs1);
    $fetch = mysqli_fetch_array($result_cs1);

    $state_del = $fetch['state'];
    $name_del = $fetch['name'];
    $num_del = $fetch['num'];
    $total_del = $fetch['total'];
    $time_before = $fetch['created'];
    $priceAvgR = $fetch['priceAvg'];
    $totalAvg = $priceAvgR*$num_del;

    //1.deal_list에서 삭제
    $sql = "
    DELETE
        FROM deal_list
        WHERE idx = $idx and uid='$uid'";

    $result = mysqli_query($conn, $sql);

    //2.current stock 처리
    //state 1일 경우와 2일 경우 나눠서
    if($state_del == '1'){
        $sql_cs = "
            UPDATE current_stock 
            SET
                num = num - $num_del,
                total = total - $total_del
            WHERE
                name = '$name_del' and uid='$uid'
                ";
        $result_cs = mysqli_query($conn, $sql_cs);

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

    } else {
        //매도의 역 == '+'
        $sql_cs = "
            UPDATE current_stock 
            SET
                num = num + $num_del,
                total = total + $totalAvg
            WHERE
                name = '$name_del' and uid='$uid'
                ";
        $result_cs = mysqli_query($conn, $sql_cs);

    }


//새 자료로 등록(단, date는 기존 created로)
    session_start();
    $name = $_POST['name'];
    $num = $_POST['num'];
    $price = $_POST['price'];
    $state = $_POST['state'];
    $total = $num*$price;
    $totalAvgR = $priceAvgR*$num;

    if($state == 1){
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
        $result_add = mysqli_query($conn, $sql);

        //자 여기서 current-stock을 건드려보자.
        //같은 이름이 있을 경우 update , 없을 경우 insert
        $sql_add = "SELECT * FROM current_stock where name='$name'";
        $result_add = mysqli_query($conn, $sql_add);
        $row = mysqli_num_rows($result_add);
        if($row == 0){
            $sql_add1 = "
            INSERT INTO current_stock
            (name, num, price, total, created, uid, uName)
            VALUES(
                '$name',
                $num,
                $price,
                $total,
                '$date',
                '{$_SESSION["id"]}',
                '{$_SESSION["name"]}'
                )";
            $result_add1 = mysqli_query($conn, $sql_add1);
        } else {
            $sql_add2 = "
                UPDATE current_stock 
                SET
                    num = num + $num,
                    total = total + $total
                WHERE
                    name = '$name' and uid='$uid'
                    ";
            $result_add2 = mysqli_query($conn, $sql_add2);

            //평균 가격 수정
            $sql_avg3 = "SELECT * FROM current_stock where name='$name'";
            $result_avg3 = mysqli_query($conn, $sql_avg3);
            $fetch_avg3 = mysqli_fetch_array($result_avg3);
            $priceAvg3 = round($fetch_avg3['total']/$fetch_avg3['num']);

            $sql_avg3 = "
                UPDATE current_stock 
                SET
                    priceAvg = $priceAvg3
                WHERE
                    name = '$name' and uid='$uid'
                    ";
            $result_avg3 = mysqli_query($conn, $sql_avg3);
        }
    } else {
        //평균 가격 등록
        $sql_aver = "SELECT * FROM current_stock where name='$name'";
        $result_aver = mysqli_query($conn, $sql_aver);
        $fetch_aver = mysqli_fetch_array($result_aver);
        $priceAver = $fetch_aver['priceAvg'];

        $sql_sell = "
            INSERT INTO deal_list
            (name, num, price, priceAvg, total, created, uid, uName, state)
            VALUES(
                '$name',
                $num,
                $price,
                $priceAvgR,
                $total,
                '$date',
                '{$_SESSION["id"]}',
                '{$_SESSION["name"]}',
                $state
                )";
        $result_sell = mysqli_query($conn, $sql_sell);

        //빼주기. 수량이 0되면 current stock view에 보여주지 말자.

        $sql_sell2 = "
            UPDATE current_stock 
            SET
                num = num - $num,
                total = total - $totalAvgR
            WHERE
                name = '$name' and uid='$uid'
                ";
        $result_sell2 = mysqli_query($conn, $sql_sell2);

    }

    

    // if($result === true && $result_cs === true && $result_add === true){
    //     echo 'success';
    // }else{
    //     echo '수정하는 과정에서 문제가 생겼습니다.';
        
        
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <script>
        window.opener.location.reload();
        window.close();
    </script>
</body>
</html>