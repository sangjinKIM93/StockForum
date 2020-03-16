<?php

$deleteList = $_POST['deleteList'];
$filteredList = implode(",", $deleteList);


$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
        DELETE
        FROM lecture_basket
        WHERE lec_idx IN ($filteredList)
        ";

    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
        
        
    }else{
        echo 'success';
        
    }

?>