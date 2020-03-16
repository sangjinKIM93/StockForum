<?php
    function display_datetime($datetime = '')
    {
        if (empty($datetime)) {
            return false;
        }

        $diff = time() - strtotime($datetime);

        $s = 60; //1분 = 60초
        $h = $s * 60; //1시간 = 60분
        $d = $h * 24; //1일 = 24시간
        $y = $d * 5; //1년 = 1일 * 5일

        if ($diff < $s) {
            $result = $diff . '초전';
        } elseif ($h > $diff && $diff >= $s) {
            $result = round($diff/$s) . '분전';
        } elseif ($d > $diff && $diff >= $h) {
            $result = round($diff/$h) . '시간전';
        } elseif ($y > $diff && $diff >= $d) {
            $result = round($diff/$d) . '일전';
        } else {
            $result = date('Y.m.d', strtotime($datetime));
        }

        return $result;
    }

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $board_num = $_GET['board_num'];

    $sql_reply = "SELECT * FROM freeboard_reply where con_num=$board_num ORDER BY idx DESC";
    $reply_data = mysqli_query($conn, $sql_reply);
    $resultArray = array();
    while($fetch = mysqli_fetch_array($reply_data)){
        $content = $fetch['content'];
        $name = $fetch['name'];
        $created = $fetch['created'];
        $filtered_created = display_datetime($created);
        $idx = $fetch['idx'];
        array_push($resultArray,array('content'=>$content, 'name'=>$name, 'created'=>$filtered_created, 'idx'=>$idx));
    }
    
    echo json_encode($resultArray);
?>