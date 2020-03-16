<?php
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
session_start();
$uid = $_SESSION['id'];
$sql = "SELECT * FROM current_stock where uid='$uid'";
$result= mysqli_query($conn, $sql);

$resultArray = array();
while($fetch = mysqli_fetch_array($result)){
    $num = $fetch['num'];
    if($num > 0){
        $name = $fetch['name'];
        $created = $fetch['created'];
        $idx = $fetch['idx'];
        $price = $fetch['price'];
        $total = $fetch['total'];
        array_push($resultArray,array('total'=>$total, 'num'=>$num, 'name'=>$name, 'created'=>$created, 'idx'=>$idx, 'price'=>$price));
    }
}


echo json_encode($resultArray);
?>