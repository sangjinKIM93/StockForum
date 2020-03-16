<?php
session_start();
$uid = $_SESSION['id'];
$uName = $_SESSION['name'];

$orderIdx = $_POST['orderIdx'];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM lectureboard WHERE idx='$orderIdx'";
$result= mysqli_query($conn, $sql);
$fetch = mysqli_fetch_array($result);

//echo $processList[0];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
    INSERT INTO order_list
    (title, lectureDay, userid, name, created, state, lec_idx)
    VALUE(
        '{$fetch['title']}',
        '{$fetch['lectureDay']}',
        '$uid',
        '$uName',
        NOW(),
        0,
        $orderIdx
    )";
$result = mysqli_query($conn, $sql);

//orderlist에 추가될때 인원 초과시 마감처리
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql_idx = "SELECT * FROM lectureboard";
$result_idx= mysqli_query($conn, $sql_idx);
$fetch =  mysqli_fetch_all($result_idx, MYSQLI_ASSOC);

foreach($fetch as $target):
    $limitation = $target['limitation'];
    //echo $limitation;
    $target_idx = $target['idx'];

    $sql_target = "SELECT * FROM order_list where lec_idx = $target_idx";
    $result_target = mysqli_query($conn, $sql_target);
    $row = mysqli_num_rows($result_target);
    //echo $row;

    if($limitation == $row){
        echo 'if문 실행';
        $sql_finished = "
                UPDATE lectureboard
                    SET
                        finished = 'on'
                    WHERE
                        idx = '$target_idx'";
        $result_finish = mysqli_query($conn, $sql_finished);
    }

endforeach;


if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
}else{
    echo 'success';
}

?>