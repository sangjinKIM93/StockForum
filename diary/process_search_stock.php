<?php
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$name = $_GET['name'];
$sql = "SELECT * FROM stock where name like '%$name%'";
$result= mysqli_query($conn, $sql);

$resultArray = array();
while($fetch = mysqli_fetch_array($result)){
    $name = $fetch['name'];
    $num = $fetch['num'];
        
    array_push($resultArray,array('name'=>$name, 'num'=>$num));
}

echo json_encode($resultArray);

?>