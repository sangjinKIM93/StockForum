<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$total = $_POST['num']*$_POST['price'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  INSERT INTO initial_setting
  (name, num, price, total, created, uid, uName)
  VALUES(
    '{$_POST['name']}',
    {$_POST['num']},
    {$_POST['price']},
    $total,
    NOW(),
    '{$_SESSION["id"]}',
    '{$_SESSION["name"]}'
    )";
    $result = mysqli_query($conn, $sql);

$sql2 = "
    INSERT INTO current_stock
    (name, num, price, total, created, uid, uName)
    VALUES(
    '{$_POST['name']}',
    {$_POST['num']},
    {$_POST['price']},
    $total,
    NOW(),
    '{$_SESSION["id"]}',
    '{$_SESSION["name"]}'
    )";
    $result2 = mysqli_query($conn, $sql2);

?>

