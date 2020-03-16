<?php
// 페이징을 위한 변수들 설정
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$query = "select * from diary_list";
$resultPaging = mysqli_query($conn, $query);
$totalArticle= mysqli_num_rows($resultPaging);    

$page = $_GET['page'];
$list = 5;
$block = 3;

$pageNum = ceil($totalArticle/$list);
$blockNum = ceil($pageNum/$block);
$nowBlock = ceil($page/$block);

$start_page = (($nowBlock-1)*$block)+1;
if($start_page <= 1){
$start_page = 1;
}
$end_page = $nowBlock*$block;
if($pageNum <= $end_page){
$end_page = $pageNum;
}

$resultArray = array();
array_push($resultArray,array('startPage'=>$start_page, 'endPage'=>$end_page, 'total'=>$totalArticle));
echo json_encode($resultArray);

?>