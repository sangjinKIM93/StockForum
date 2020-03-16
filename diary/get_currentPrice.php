<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'simple_html_dom.php';
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
session_start();
$uid = $_SESSION['id'];
$sql = "SELECT * FROM current_stock where uid='$uid'";
$result= mysqli_query($conn, $sql);

$resultArray = array();
while($fetch = mysqli_fetch_array($result)){
    $stockNum = $fetch['stockNum'];
    $idx = $fetch['idx'];
    $num = $fetch['num'];
    $price = $fetch['price'];
    $priceAvg = $fetch['priceAvg'];

    $url = 'https://finance.naver.com/item/main.nhn?code='.$stockNum;
    $html = file_get_html($url);
    $a = $html->find('div[class=today]');
    $c = $a[0]->find('span[class=blind]');
    $current_price = $c[0]->innertext;
    
    array_push($resultArray,array('priceAvg'=>$priceAvg,'num'=>$num, 'current_price'=>$current_price, 'idx'=>$idx, 'price'=>$price));
}

//아 여기서 코롤링 해서 넘겨주면 되겠네.

echo json_encode($resultArray);
?>