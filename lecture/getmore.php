<?php
//이미지 가져오기
$start_point = $_GET['start_point'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql_img = "SELECT * FROM lectureboard WHERE idx<$start_point AND deleted = '0' order by idx DESC Limit 4";
$result_img= mysqli_query($conn, $sql_img);
$length = mysqli_num_rows($result_img);
$resultArray = array();
    while($fetch = mysqli_fetch_array($result_img)){
        $title = $fetch['title'];
        $lectureDay = $fetch['lectureDay'];
        $imageFile = $fetch['imageFile'];
        $idx = $fetch['idx'];
        $checked = $fetch['finished'];
    
        array_push($resultArray,array('title'=>$title, 'lectureDay'=>$lectureDay, 'imageFile'=>$imageFile, 'idx'=>$idx, 'length'=>$length, 'checked'=>$checked));
    }
    
    echo json_encode($resultArray);
?>