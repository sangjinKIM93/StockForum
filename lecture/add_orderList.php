<?php
session_start();
$uid = $_SESSION['id'];
$uName = $_SESSION['name'];

$processList = $_POST['orderList'];
$filteredList = implode(",", $processList);

//echo $processList[0];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
    INSERT INTO order_list
    (title, lectureDay, userid, name, created, state, lec_idx)
    SELECT 
    title, lectureDay, userid, name, created, state, lec_idx
    FROM lecture_basket where lec_idx IN ($filteredList) AND userid='$uid'";


//orderlist에 추가될때 처리해야해.
//해당 lec_idx 의 row 수 & 해당 정원
//1.모든 lecture를 다 가져온다.
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

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
}else{
    echo 'success';
}


?>