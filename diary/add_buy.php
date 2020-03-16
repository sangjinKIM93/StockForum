<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$inputArray_str = $_POST['inputArray_str'];
$inputArray_str = (array) json_decode($inputArray_str);
$total = $inputArray_str['num']*$inputArray_str['price'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
if($inputArray_str['state']=='1'){
    $sql = "
    INSERT INTO current_stock
    (name, num, price, total, created, uid, uName)
    VALUES(
        '{$inputArray_str['name']}',
        {$inputArray_str['num']},
        {$inputArray_str['price']},
        $total,
        NOW(),
        '{$_SESSION["id"]}',
        '{$_SESSION["name"]}'
        )";
    $result = mysqli_query($conn, $sql);
} else {
    $sql2 = "
        UPDATE current_stock 
        SET
            num = num + {$inputArray_str['num']},
            total = total + $total
        WHERE
            name = '{$inputArray_str['name']}'
            ";
    $result2 = mysqli_query($conn, $sql2);
    echo $inputArray_str['name'];
}

//echo '<script>console.log($name)</script>';



?>