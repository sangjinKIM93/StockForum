<?php
session_start();
$uid = $_SESSION['id'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");



//날짜 변환
function display_datetime($datetime = '')
{
    if (empty($datetime)) {
        return false;
    }

    $diff = time() - strtotime($datetime);

    $s = 60; //1분 = 60초
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $y = $d * 3; //1년 = 1일 * 3일

    if ($diff < $s) {
        $result = $diff . '초전';
    } elseif ($h > $diff && $diff >= $s) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff && $diff >= $h) {
        $result = round($diff/$h) . '시간전';
    } elseif ($y > $diff && $diff >= $d) {
        $result = round($diff/$d) . '일전';
    } else {
        $result = date('Y.m.d.', strtotime($datetime));
    }

    return $result;
}

error_reporting(E_ALL);
ini_set("display_errors", 1);
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

// $sql_reply = "SELECT * FROM deal_list where uid='$uid' and state=1 ORDER BY created DESC";
// $data1 = mysqli_query($conn, $sql_reply);

$sql_reply = "SELECT * FROM deal_list where uid='$uid' and state=2 ORDER BY created DESC";
$data2 = mysqli_query($conn, $sql_reply);
$totalProfit = 0;
while($fetchSell = mysqli_fetch_array($data2)){
    
    $totalProfit += ($fetchSell['price']-$fetchSell['priceAvg'])*$fetchSell['num'];
    
}


$totalBuy = 0 ;
$totalSell = 0;
//$totalProfit = 0;
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
      <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/heroic-features.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <style>
    .tableBuy{
        max-height: 600px;
        overflow: auto;
    }
    </style>
</head>
<body>
<div class="container">
<h4>매수 기록</h4>
    <div class="tableBuy">
    <table class="table table-bordered" >
        <thead>
            <tr>
                <td>구분</td>
                <td>종목명</td>
                <td>수량</td>
                <td>가격</td>
                <td>총액</td>
                <td>날짜</td>
            </tr> 
        </thead>
        <tbody id="buyStock">
            
        </tbody>
    </table>
    <!-- 페이징 버튼. 부트스트랩 활용 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="pagination">
        
      </ul>
    </nav>
    </div><br>
    

<h4>매도 기록</h4>
    <div class="tableBuy">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>구분</td>
                <td>종목명</td>
                <td>수량</td>
                <td>가격</td>
                <td>총액</td>
                <td>평균매입단가</td>
                <td>손익</td>
                <td>날짜</td>
            </tr> 
        </thead>
        <tbody id="sellStock">
    
        </tbody>
        <tbody>
            <tr>
                <td>총액</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?=number_format($totalProfit)?></td>
                <td></td>
            </tr> 
        </tbody>
    </table>
    <!-- 페이징 버튼. 부트스트랩 활용 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="paginationM">
        
      </ul>
    </nav>
    </div><br><br>



</div>



<script>
$(document).ready(function(){
        getDealList(1);
        nextBtnClicked(1);
        nextBtnClickedM(1);
        getMemoList(1);
     
        
    });

    //페이징 이전&다음 버튼 확인
function nextBtnClicked(num){

$.getJSON("paging_buy.php?page="+num, function(data){
    //기존 페이지 버튼(이전,다음 포함) 삭제
    $("#pagination *").remove();    

    $(data).each(function(){
       
        var numList = "";
        for(var i=this.startPage; i<=this.endPage; i++){
            numList += '<li class="page-item pageItem num-item'+i+'"><a class="page-link" onclick="getDealList('+i+')">'+i+'</a></li>';
        }
    
        var nextPage = parseInt(this.endPage)+1;
        var beforePage = parseInt(this.startPage)-1;

        var differ = nextPage - beforePage;
        var pageContent
        //3보다 적을 경우 다음 눌러도 페이징이 진행되는 경우 방지
        if(differ < 4){
            pageContent = 
            '<li class="page-item">\
            <a class="page-link" onclick="beforeBtnClicked('+beforePage+')">이전</a>\
            </li>\
            '+numList+'\
            <li class="page-item">\
            <a class="page-link">다음</a>\
            </li>';
        }else{
            pageContent = 
            '<li class="page-item">\
            <a class="page-link" onclick="beforeBtnClicked('+beforePage+')">이전</a>\
            </li>\
            '+numList+'\
            <li class="page-item">\
            <a class="page-link" onclick="nextBtnClicked('+nextPage+')">다음</a>\
            </li>';
        }
        
        $("#pagination").append(pageContent);
        getDealList(this.startPage);    //바뀐 버튼의 첫번째 deal_list 가져오기
    });
});   
}
//페이징 이전&다음 버튼 확인
function beforeBtnClicked(num){
if(num>0){
    $.getJSON("paging_buy.php?page="+num, function(data){
        //기존 페이지 버튼(이전,다음 포함) 삭제
        $("#pagination *").remove();    

        $(data).each(function(){
        
            var numList = "";
            for(var i=this.startPage; i<=this.endPage; i++){
                numList += '<li class="page-item pageItem num-item'+i+'"><a class="page-link" onclick="getDealList('+i+')">'+i+'</a></li>';
            }
        
            var nextPage = parseInt(this.endPage)+1;
            var beforePage = parseInt(this.startPage)-1;
            

            //다시 만들 페이지 버튼
            var pageContent = 
            '<li class="page-item">\
            <a class="page-link" onclick="beforeBtnClicked('+beforePage+')">이전</a>\
            </li>\
            '+numList+'\
            <li class="page-item">\
            <a class="page-link" onclick="nextBtnClicked('+nextPage+')">다음</a>\
            </li>';
            
            $("#pagination").append(pageContent);
            getDealList(this.startPage);
        });
    });
}
}


//페이징 이전&다음 버튼 확인
function nextBtnClickedM(num){

$.getJSON("paging_sell.php?page="+num, function(data){
    //기존 페이지 버튼(이전,다음 포함) 삭제
    $("#paginationM *").remove();    

    $(data).each(function(){
    
        var numList = "";
        for(var i=this.startPage; i<=this.endPage; i++){
            numList += '<li class="page-item pageItem2 num-itemm'+i+'"><a class="page-link" onclick="getMemoList('+i+')">'+i+'</a></li>';
        }
    
        var nextPage = parseInt(this.endPage)+1;
        var beforePage = parseInt(this.startPage)-1;
        
        var differ = nextPage - beforePage;
        console.log(nextPage);
        console.log(beforePage);
        console.log(differ);
        var pageContent
        //3보다 적을 경우 다음 눌러도 페이징이 진행되는 경우 방지
        if(differ < 4){
            pageContent = 
            '<li class="page-item">\
            <a class="page-link" onclick="beforeBtnClickedM('+beforePage+')">이전</a>\
            </li>\
            '+numList+'\
            <li class="page-item">\
            <a class="page-link">다음</a>\
            </li>';
        }else{
            var pageContent = 
            '<li class="page-item">\
            <a class="page-link" onclick="beforeBtnClickedM('+beforePage+')">이전</a>\
            </li>\
            '+numList+'\
            <li class="page-item">\
            <a class="page-link" onclick="nextBtnClickedM('+nextPage+')">다음</a>\
            </li>';
        }
        
        $("#paginationM").append(pageContent);
        getMemoList(this.startPage);
    });
});   
}
//페이징 이전&다음 버튼 확인
function beforeBtnClickedM(num){
if(num>0){
$.getJSON("paging_sell.php?page="+num, function(data){
    //기존 페이지 버튼(이전,다음 포함) 삭제
    $("#paginationM *").remove();    

    $(data).each(function(){
    
        var numList = "";
        for(var i=this.startPage; i<=this.endPage; i++){
            numList += '<li class="page-item pageItem2 num-itemm'+i+'"><a class="page-link" onclick="getMemoList('+i+')">'+i+'</a></li>';
        }
    
        var nextPage = parseInt(this.endPage)+1;
        var beforePage = parseInt(this.startPage)-1;
        

        //다시 만들 페이지 버튼
        var pageContent = 
        '<li class="page-item">\
        <a class="page-link" onclick="beforeBtnClickedM('+beforePage+')">이전</a>\
        </li>\
        '+numList+'\
        <li class="page-item">\
        <a class="page-link" onclick="nextBtnClickedM('+nextPage+')">다음</a>\
        </li>';
        
        $("#paginationM").append(pageContent);
        getMemoList(this.startPage);
    });
});
}
}

function filterState(stat){
        if(stat=='1'){
            return '<p style="color:red">매수</p>';
        } 
        if(stat=='2'){
            return '<p style="color:blue">매도</p>';
        } 
        if(stat=='0'){
            return '<p style="color:orange">단상</p>';
        }
    }

function addComma(num)
{
var regexp = /\B(?=(\d{3})+(?!\d))/g;
return num.toString().replace(regexp, ',');
}

function getDealList(page){
        $.getJSON("report_buy.php?page="+page, function(data){
            $('.pageItem').removeClass("active");
            $('.num-item'+page).addClass("active");

            $("#buyStock *").remove();
            $(data).each(function(){
            var filter_state = filterState(this.state);
            var priceDeal = addComma(this.price)
            var totalDeal = addComma(this.total)
                
            var list_deal='<tr>\
                                <td>'+filter_state+'</td>\
                                <td>'+this.name+'</td>\
                                <td>'+this.num+'</td>\
                                <td>'+priceDeal+'</td>\
                                <td>'+totalDeal+'</td>\
                                <td>'+this.created+'</td>\
                            </tr>';
                
            $("#buyStock").append(list_deal);  
              
            });    
            
        });
    }

    function getMemoList(page){
        $.getJSON("report_sell.php?page="+page, function(data){
            $('.pageItem2').removeClass("active");
            $('.num-itemm'+page).addClass("active");


            $("#sellStock *").remove();
            $(data).each(function(){
            var filter_state = filterState(this.state);
            var priceDeal = addComma(this.price)
            var totalDeal = addComma(this.total)
            var priceAvg = addComma(this.priceAvg)
            var profit = (this.price - this.priceAvg)*this.num;
            profit = parseInt(profit);
            profit = addComma(profit);
                
            var list_deal='<tr>\
                                <td>'+filter_state+'</td>\
                                <td>'+this.name+'</td>\
                                <td>'+this.num+'</td>\
                                <td>'+priceDeal+'</td>\
                                <td>'+totalDeal+'</td>\
                                <td>'+priceAvg+'</td>\
                                <td>'+profit+'</td>\
                                <td>'+this.created+'</td>\
                            </tr>';
                
                $("#sellStock").append(list_deal);     
            });    
            
        });
    }
</script>

    <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>