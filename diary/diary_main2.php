<?php
session_start();
$uid = $_SESSION['uid'];
if(isset($_SESSION["id"])) {

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql = "SELECT * FROM current_stock where uid='$uid'";
$result= mysqli_query($conn, $sql);
$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC);

//datepicker 초기값 설정을 위한 변수
$initialDate = date('Y/m/d');     //time -> str(내가 원하는 형식)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Quant-Forum</title>
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/heroic-features.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Add icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <!-- jquery for DatePicker -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- datepicker -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  
  <style>
  .table-wrapper{
      overflow:auto;
      max-height:500px;
  }

  .overlay {
    position:fixed;
    display:none;
    /* color with alpha channel */
    background-color: rgba(0, 0, 0, 0.7); /* 0.7 = 70% opacity */
    /* stretch to screen edges, 블러된 부분 조절. 안 건드리는게 좋을듯*/
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    }

    #myCurrentStock{
        max-height:600px;
        overflow:auto;
    }

    .principleList{
        width:600px;
        max-height:auto;
        position:absolute;
        left:50%;
        top:30%;
        margin-left:-300px;
        margin-top:-150px;
        background: white;
    }
    #floatingBar{
        position: fixed;
        left:2%;
        top:10%;
    }
    #floatingContent{
        position: fixed;
        left:2%;
        top:23%;
        width:500px;
        max-height:500px;
        background: gold;
        display: none;
        /* border: 1px solid gold; */
	    border-radius: .4em;
        
    }
    #floatingContent:after {
        content: '';
        position: absolute;
        top: 0;
        left: 17%;
        width: 0;
        height: 0;
        border: 20px solid transparent;
        border-bottom-color: gold;
        border-top: 0;
        border-right: 0;
	    margin-left: -10px;
        margin-top: -20px;
    }
    #ulList{
        overflow:auto;
        max-height: 400px;
    }
    .page-link.active{
        background-color: #4CAF50;
    }
  </style>
</head>
<body>
<!-- Navigation -->
<?php include 'menubar_diary.php'; ?>

<button id="floatingBar" class="btn btn-warning"><img src="decision.png" alt="">&ensp;Principle</button>
<div id="floatingContent">
    <div class="container"><br><br>
       
        <h5 style="text-align:center; text-decoration:underline; text-underline-position:under;">원숭이가 되지 말자.</h5><br>
        <ul class="list-group list-group-flush" id="ulList">
            <!-- 로딩 화면 -->
            <div class="d-flex justify-content-center">
                <div id= "principleLoading" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </ul><br>
        <button class="btn btn-outline-dark" style="float:right" onclick="location.href='principle.php'">추가/수정</button><br><br>
    </div>
</div>

<div class="container" id="main">
<div class="container">
<h3 style="text-decoration:underline; text-underline-position:under; text-align:center">투자 일기</h3><br>
    
<!-- 팝업 원칙 -->
<!-- <div class="overlay">
    <div class="principleList" >
        <button class="popupBtn btn btn-link" style="float:right"><i class="fa fa-remove"></i></button>
        <div class="container"><br><br>
            <h3 style="text-align:center; text-decoration:underline; text-underline-position:under;">원숭이보다 뛰어나기 위한 방법</h3><br>
            <ul class="list-group list-group-flush" id="ulList">
                
            </ul><br><br><br>
            <button class="btn btn-primary" style="float:right" onclick="location.href='principle.php'">수정</button>
            <button class="cookieMake btn btn-link" style="float:left">오늘 하루 보지않기</button><br><br><br>
        </div>
    </div>
</div> -->
    <button class="btn btn-secondary" style="float:right" onclick="popup9()">모든 종목 보기</button>    
    <button class="btn btn-primary" style="float:right" onclick="getCurrentPrice()">현재 가격 크롤링</button>
    <h4>나의 주식 현황</h4><br>
    <div id="myCurrentStock">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td style="width:25%">종목명</td>
                <td>수량</td>
                <td style="width:17%">매입가격(평균)</td>
                <td style="width:17%">현재가격</td>
                <td style="width:15%">수익률</td>
                <td style="width:15%">버튼</td>
            </tr>
        </thead>
        <tbody class="initialList">
            
        </tbody>
    </table>
    </div><br>

    <div class="text-center">
        <button class="btn btn-outline-danger" onclick="select_new()">매수 기록하기</button>
        <button class="btn btn-outline-primary" onclick="select_pre()">매도 기록하기</button>
    </div><br>

    <div class="inputForm">

    </div><br><br>

    <button class="btn btn-info" style="float:right" onclick="popup7()">매수/매도 결산</button>
    <h4>매수/매도 기록</h4><br>
    <div class="table-wrapper">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>구분</td>
                <td>종목명</td>
                <td>수량</td>
                <td>가격</td>
                <td>총액</td>
                <td>날짜</td>
                <td style="width:15%">수정/삭제</td>
                <td style="width:12%">메모</td>
            </tr>
        </thead>
        <tbody class="dealList">
            
        </tbody>
    </table>
    <!-- 페이징 버튼. 부트스트랩 활용 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="pagination">
        
      </ul>
    </nav>
    </div><br><br><br>


    <button class="btn btn-warning" style="float:right" onclick="popup5()">메모 작성(자유)</button>
    <h4>투자 메모</h4><br>
    <table class="table table-hover">
        <thead>
            <tr>
                <td>구분</td>
                <td style="width: 50%">제목</td>
                <td style="width: 15%">종목명</td>
                <td>날짜</td>
            </tr>
        </thead>
        <tbody class="memoList">
            
        </tbody>
    </table><br>
    <!-- 페이징 버튼. 부트스트랩 활용 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="paginationM"  style="cursor:pointer">
        
      </ul>
    </nav>
    </div><br><br><br>

        

    <!-- <button class="btn btn-outline-primary" onclick="add_buy()">test</button>  -->

</div>

  <script>
    $(document).ready(function(){
        nextBtnClicked(1);
        getDealList(1);
        nextBtnClickedM(1);
        getMemoList(1);
        getInitialList();
        getMemoList();
        getPrincipleList();
        //getCurrentPrice();
        
    });
    

    //페이징 이전&다음 버튼 확인
    function nextBtnClicked(num){

        $.getJSON("paging.php?page="+num, function(data){
            //기존 페이지 버튼(이전,다음 포함) 삭제
            $("#pagination *").remove();    

            $(data).each(function(){
               
                var numList = "";
                for(var i=this.startPage; i<=this.endPage; i++){
                    numList += '<li class="page-item pageItem num-item'+i+'" style="cursor:pointer"><a class="page-link" onclick="getDealList('+i+')">'+i+'</a></li>';
                }
            
                var nextPage = parseInt(this.endPage)+1;
                var beforePage = parseInt(this.startPage)-1;

                var differ = nextPage - beforePage;
                var pageContent
                //3보다 적을 경우 다음 눌러도 페이징이 진행되는 경우 방지
                if(differ < 4){
                    pageContent = 
                    '<li class="page-item"  style="cursor:pointer">\
                    <a class="page-link" onclick="beforeBtnClicked('+beforePage+')">이전</a>\
                    </li>\
                    '+numList+'\
                    <li class="page-item"  style="cursor:pointer">\
                    <a class="page-link">다음</a>\
                    </li>';
                }else{
                    var pageContent = 
                    '<li class="page-item"  style="cursor:pointer">\
                    <a class="page-link" onclick="beforeBtnClicked('+beforePage+')">이전</a>\
                    </li>\
                    '+numList+'\
                    <li class="page-item"  style="cursor:pointer">\
                    <a class="page-link" onclick="nextBtnClicked('+nextPage+')">다음</a>\
                    </li>';
                }
                
                $("#pagination").append(pageContent);
                getDealList(this.startPage);
            });
        });   
    }
    //페이징 이전&다음 버튼 확인
    function beforeBtnClicked(num){
        if(num>0){
            $.getJSON("paging.php?page="+num, function(data){
                //기존 페이지 버튼(이전,다음 포함) 삭제
                $("#pagination *").remove();    

                $(data).each(function(){
                
                    var numList = "";
                    for(var i=this.startPage; i<=this.endPage; i++){
                        numList += '<li class="page-item pageItem num-item'+i+'"  style="cursor:pointer"><a class="page-link" onclick="getDealList('+i+')">'+i+'</a></li>';
                    }
                
                    var nextPage = parseInt(this.endPage)+1;
                    var beforePage = parseInt(this.startPage)-1;
                    

                    //다시 만들 페이지 버튼
                    var pageContent = 
                    '<li class="page-item"  style="cursor:pointer">\
                    <a class="page-link" onclick="beforeBtnClicked('+beforePage+')">이전</a>\
                    </li>\
                    '+numList+'\
                    <li class="page-item"  style="cursor:pointer">\
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

        $.getJSON("pagingMemo.php?page="+num, function(data){
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
        $.getJSON("pagingMemo.php?page="+num, function(data){
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

    //floatingContent 보이기&숨기기
    jQuery('#floatingBar').click(function(){
        if($('#floatingContent').css("display")=="none"){
            jQuery('#floatingContent').css("display", "block");
            jQuery('#main').css("float", "right");
        }else{
            jQuery('#floatingContent').css("display", "none");
            jQuery('#main').css("float", "none");
        }
    });

    //팝업에 띄울 원칙 리스트 가져오기
    function getPrincipleList(){
        var btnRefer = "";
        $.getJSON("principle_list.php", function(data){
            $(".list-group *").remove();
            $(data).each(function(){            
                                
                //reference가 있는지 없는지 확인 -> 버튼 유/무
                if(this.reference != null){
                    btnRefer = '<button class="btn btn-link" onClick="popup8('+this.idx+')" style="cursor:pointer"><i class="fa fa-sticky-note-o"></i></button>';
                } else {
                    btnRefer="";
                }
                
                $(".list-group").append('<div id="'+this.idx+'" ><li class="list-group-item" >'+this.content+btnRefer+'</li></div>');
            });    
            $('#principleLoading').css("display", "none");
        });  
    }

    //버튼 클릭시 팝업뜨면서 주변 블러, 다시 클릭시 블러 사라짐.
    $(".popupBtn").click(function() {
        $(".overlay").toggle(); // show/hide the overlay
    });

    //일주일간 보지 않기.cookie 생성
    $(".cookieMake").click(function() {
        var valueDate= new Date();
        valueDate.setDate(valueDate.getDate()+1);
        document.cookie = 'principle=no; expires='+valueDate.toGMTString()+'; path=/';
        $(".overlay").toggle();
    });

    //cookie 값 얻어오기
    // var cookie = document.cookie;
    // var startIndexOf =cookie.indexOf('principle');
    // var endIndexOf = cookie.indexOf(';', startIndexOf);
    // if(endIndexOf == -1)endIndexOf = cookie.length;
    // cookie.substring(startIndexOf+'principle='.length, endIndexOf);
    // console.log("cookieget()");
     //console.log(cookie.indexOf('principle'));

    function addComma(num)
    {
    var regexp = /\B(?=(\d{3})+(?!\d))/g;
    return num.toString().replace(regexp, ',');
    }

    priceArray = new Array();
    function getCurrentPrice(){
        
        $('.currentPriceLoading').html('<div class="spinner-border"></div>');
        $.getJSON("get_currentPrice.php", function(data){
            
            var total_current = 0;
            var total_price = 0;
            var total_ratio = 0;
            $(data).each(function(){
                priceArray.push(this.current_price);

                //색깔 처리를 위한 int화
                var filter_price = this.current_price.replace(",","");
                filter_currentprice = parseInt(filter_price);
                filter_price = parseInt(this.priceAvg);

                //total 계산을 위한 처리
                filter_num = parseInt(this.num);
                total_current += filter_currentprice*filter_num;
                total_price += filter_price*filter_num;
                

                //현재 가격
                if(filter_currentprice > filter_price){
                    price_html = '<p style="color: red">'+this.current_price+'</p>';
                } else {
                    price_html = '<p style="color: blue">'+this.current_price+'</p>';
                }
                $("#"+this.idx).html(price_html);  

                //수익률 계산
                var ratio = (filter_currentprice-this.priceAvg)/this.priceAvg*100;
                ratio = ratio.toFixed(1)+"%";
                if(filter_currentprice > filter_price){
                    ratio = '<p style="color: red">'+ratio+'</p>';
                } else {
                    ratio = '<p style="color: blue">'+ratio+'</p>';
                }
                $("#rate"+this.idx).html(ratio);  
                
            });  
            console.log(total_current);
            console.log(total_price);
            
            total_ratio = (total_current-total_price)/total_price*100;
            total_ratio = total_ratio.toFixed(1)+"%";
            console.log(total_ratio);

            //total_current / total_ratio처리
            if(total_current > total_price){
                    total_current = '<p style="color: red">'+addComma(total_current)+'</p>';
                    total_ratio = '<p style="color: red">'+total_ratio+'</p>';
                } else {
                    total_current = '<p style="color: blue">'+addComma(total_current)+'</p>';
                    total_ratio = '<p style="color: blue">'+total_ratio+'</p>';
                }
            $("#total_current").html(total_current);  
            $("#total_ratio").html(total_ratio);  

        });
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

    //매수 처리
    function buy_stock(){
        var formData1 = $("#form1").serialize();
        $.ajax({
            type: 'POST',
            url : 'buy_new.php',
            data :formData1,
            success : function(response){
                if(response=='success'){
                    getDealList();
                    getInitialList();
                    getCurrentPrice();
                }else{
                    console.log(response);
                } 
            }
        });
        
    }

    //매도 처리
    function sell_stock(){
        var formData1 = $("#form1").serialize();
        $.ajax({
            type: 'POST',
            url : 'sell_stock.php',
            data :formData1,
            success : function(response){
                if(response=='success'){
                    getDealList();
                    getInitialList();
                    getCurrentPrice();
                    select_pre()
                }else{
                    console.log(response);
                } 
            }
        });
        
    }

    function delete_deal(del_idx){
        $.ajax({
            type: 'POST',
            url : 'delete_deal.php',
            data :{'del_idx':del_idx},
            success : function(response){
                if(response=='success'){
                    getDealList();
                    getInitialList();
                    getCurrentPrice();
                }else{
                    console.log(response);
                } 
            }
        });
    }

    //메모 작성
    function writeMemo(idx_memo){
        popup(idx_memo);
    }

    $(document).on("keyup", "input[id^=sellNum]", function() {
        var val= $(this).val();
        var name = String($("#sellName option:selected").val());
        console.log(name);
        var num;
        // 자. 여기서 ajax로 매도 가능 수량을 받아와야해.
        $.getJSON("get_num.php?name="+name, function(data){
            //매수 후 매도로 옮겼을때 최신화가 안 되는 문제 해결
            $(data).each(function(){
                num = this.num;
                num = parseInt(num);
            });  

            //getjson이 콜백 함수라 어쩔 수 없이 여기다 넣음.
            if(val < 1 || val > num) {
                alert("1~"+num+"범위로 입력해 주십시오.");
                $("#sellNum").val('');
            }  
        });   
        
    });


    function select_new(){
        var new_btn= '<div class="form-group col-1"><label for="inputPassword4">&ensp;</label><input type="submit" class="form-control btn btn-danger" value="제출" placeholder="Password" onclick="buy_stock(); return false;"></div>';
        var new_form = '<form id="form1">\
        <input type="hidden" id="state" name="state" value="1">\
        <div class="form-row">\
            <div class="form-group col">\
            <label for="inputEmail4">종목 이름</label>\
                <div class="input-group">\
                <input type="text" id="name" class="form-control" name="name" placeholder="검색 버튼을 눌러주세요">\
                <button type="button" class="btn btn-secondary" style="width:15%" onclick="popup6()"><i class="fa fa-search"></i></button>\
                </div>\
            </div>\
            <div class="form-group col-2"><label for="inputPassword4">종목번호</label><input type="text"  class="form-control number" name="stockNum" id="stockNum" placeholder="종목번호"></div>\
        <div class="form-group col-2"><label for="inputPassword4">수량</label><input style="IME-MODE: disabled"  type="number"  id="num" class="form-control number" name="num" placeholder="수량" ></div><div class="form-group col-2"><label for="inputPassword4">매수 가격</label><input type="number" style="IME-MODE: disabled"  id="price" class="form-control" name="price" placeholder="가격"></div>\
        <div class="form-group col-2"><label for="inputPassword4">날짜</label><input type="text" class="form-control datepicker" id="datepicker" name="day" placeholder="click here!"/></div>'+new_btn+'</div></form>';
        
        $(".inputForm *").remove();
        $(".inputForm").append(new_form);

        
        $("#datepicker").datepicker({dateFormat:'yy/mm/dd'})
        $("#datepicker").datepicker('setDate', '<?=$initialDate?>');
    }
    

    function select_pre(){
        var select_list = "";
        $.getJSON("get_select.php", function(data){
            //매수 후 매도로 옮겼을때 최신화가 안 되는 문제 해결
            $(data).each(function(){
                select_list += '<option value="'+this.name+'">'+this.name+'</option>';
                
            });    
            var pre_btn= '<div class="form-group col-1"><label for="inputPassword4">&ensp;</label><input type="submit" class="form-control btn btn-primary" value="제출" placeholder="Password" onclick="sell_stock(); return false;"></div>';
            var name_select = '<select name="name" id="sellName" class="form-control" id="name">'+select_list+'</select>';
            var pre_form = '<form id="form1">\
            <input type="hidden" id="state" name="state" value="2">\
            <div class="form-row">\
            <div class="form-group col">\
            <label for="inputEmail4">종목 이름</label>'+name_select+'</div>\
            <div class="form-group col-2"><label for="inputPassword4">수량</label>\
            <input type="number" style="IME-MODE: disabled"  id="sellNum" class="form-control" name="num" placeholder="수량"></div>\
            <div class="form-group col"><label for="inputPassword4">매도 가격</label><input type="number" style="IME-MODE: disabled" id="price" class="form-control" name="price" placeholder="가격"></div><div class="form-group col-2"><label for="inputPassword4">날짜</label><input type="text" class="form-control datepicker" id="datepicker" name="day" placeholder="click here!"/></div>'+pre_btn+'</div></form>';
            $(".inputForm *").remove();
            $(".inputForm").append(pre_form);

            $("#datepicker").datepicker({dateFormat:'yy/mm/dd'});   
            $("#datepicker").datepicker('setDate', '<?=$initialDate?>'); 
        });   
         
    }


    function add_initial(){
        var formData = $('#form_initial').serialize();
        $.ajax({
            type: 'POST',
            url : 'process_diary.php',
            data : formData,
            success : function(response){
                if(response=='success'){
                    console.log('ajax success!');
                    getInitialList();
                }
            }
        });
    }

    function getInitialList(){
        $.getJSON("initial_list.php", function(data){
            var total_price = 0;
            $(".initialList *").remove();
            $(data).each(function(){
                var str_name = "'"+this.name+"'";

                //평균 구하기
                var parTotal = parseInt(this.total);
                var parNum = parseInt(this.num);
                var avg = Math.round(parTotal/parNum);
                avg = addComma(avg);
                total_price += parTotal;

                var target_detail = '<td><button class="btn btn-secondary" onclick="popup4('+str_name+')">상세내역</button></td>';
                var initialList = '<tr><td>'+this.name+'</td><td>'+this.num+'</td><td>'+avg+'</td><td id="'+this.idx+'" class="currentPriceLoading">'+"-"+'</td><td id="rate'+this.idx+'" class="currentPriceLoading">'+"-"+'</td>'+target_detail+'</tr>';
                $(".initialList").append(initialList);
                
            });   
            total_price_html = 
            '<tr>\
                <td>총합(수량*가격)</td>\
                <td></td>\
                <td>'+addComma(total_price)+'</td>\
                <td id="total_current" class="currentPriceLoading">-</td>\
                <td id="total_ratio" class="currentPriceLoading">-</td>\
                <td></td>\
            </tr>';
            $(".initialList").append(total_price_html);
        });
    }

    function getDealList(page){
        $.getJSON("deal_list.php?page="+page, function(data){
            $('.pageItem').removeClass("active");
            $('.num-item'+page).addClass("active");

            $(".dealList *").remove();
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
                                <td><button class="btn btn-primary" onclick="popup3('+this.idx+')">수정</button>\
                                    <button class="btn btn-primary" onclick="delete_deal('+this.idx+')">삭제</button></td>\
                                <td><button class="btn btn-warning" onclick="writeMemo('+this.idx+')">메모작성</button></td>\
                            </tr>';
                
                $(".dealList").append(list_deal);     
            });    
            
        });
    }

    function getMemoList(page){
        $.getJSON("memo_list.php?page="+page, function(data){
            $('.pageItem2').removeClass("active");
            $('.num-itemm'+page).addClass("active");

            $(".memoList *").remove();
            $(data).each(function(){
                //var initial_delete = '<td><form id="formDel'+this.idx+'" action="delete_initial.php" method="post"><input type="hidden" name="idx" value="'+this.idx+'"><input type="submit" value="거래내역" onclick="delete_initial('+this.idx+'); return false;"></form></td>';
                if(this.name==null){
                    this.name = "";
                }
                var filter_state = filterState(this.state);
                var memoList = 
                            '<tr style="cursor:pointer" onclick="popup2('+this.idx+')">\
                                <td>'+filter_state+'</td>\
                                <td>'+this.title+'</a></td>\
                                <td>'+this.name+'</td>\
                                <td>'+this.created+'</td>\
                            </tr>';
                $(".memoList").append(memoList);
                
            });    
        });
    }

    function popup(idx){
      var url = "memo_write.php?idx="+idx;
      var name = "memoWrite";
      var option = "width = 650, height = 500, top=50, left=350, location=no";
      window.open(url, name, option);
    }
    function popup2(idx){
      var url = "memo_view.php?idx="+idx;
      var name = "popup.test";
      var option = "width = 750, height = 500, top=50, left=350, location=no";
      window.open(url, name, option);
    }
    function popup3(idx){
      var url = "deal_edit.php?idx="+idx;
      var name = "popup.test";
      var option = "width = 650, height = 300, top=50, left=350, location=no";
      window.open(url, name, option);
    }
    function popup4(name){
      var url = "target_detail.php?name="+name;
      var name = "popup.test";
      var option2 = "width = 650, height = 500, top=50, left=350, toolbar=yes";
      window.open(url, name, option2);
    }
    function popup5(){
      var url = "memo_write.php";
      var name = "popup.test";
      var option = "width = 650, height = 500, top=50, left=350, location=no";
      window.open(url, name, option);
    }
    function popup6(){
      var url = "search_stock.php";
      var name = "popup.test";
      var option = "width = 450, height = 300, top=50, left=150, location=no";
      window.open(url, name, option);
    }
    function popup7(){
      var url = "report.php";
      var name = "popup.test";
      var option = "width = 850, height = 600, top=50, left=150, location=no";
      window.open(url, name, option);
    }
    function popup8(idx){
      var url = "reference_view.php?idx="+idx;
      var name = "reference_view";
      var option = "width = 550, height = 300, top=50, left=350, location=no";
      window.open(url, name, option);
    }
    function popup9(){
      var url = "all_stock.php";
      var name = "all_stock";
      var option = "width = 550, height = 700, top=50, left=350, location=no";
      window.open(url, name, option);
    }
  </script>
  <!-- Bootstrap core JavaScript -->
  <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
}else{
?>
로그인 후 이용해주세요.
<?php }?>