<?php
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
function connect_mysqli($ip,$user,$password,$db){

    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

    if(!$conn = mysqli_connect($ip,$user,$password)){
        echo "mysql 연결실패<br />";
    }
    //mysql_query("SET NAMES UTF8");
    if(!mysqli_select_db($conn,$db)){
        echo "db 선택 실패<br />";
    }
    return $conn;
}
 
?>