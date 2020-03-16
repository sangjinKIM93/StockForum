<?php
session_start();
$uid = $_SESSION['id'];
$uName = $_SESSION['name'];
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
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

    <style>
    .grid_price{
        float: right;
    }
    </style>
</head>
<body>
  <!-- Navigation -->
  <?php include 'menubar_lecture.php'; ?>
  <div class="container">
    <button type="button" class="btn btn-outline-secondary" style="float:left" onclick="checkAll()">전체 선택</button>
    <button type="button" class="btn btn-outline-secondary" style="float:left" onclick="uncheckAll()">전체 해제</button>
    <br><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>check</td>
                <td>제목</td>
                <td>날짜</td>
                <td>가격</td>
                <td>강연 번호</td>
            </tr>
        </thead>
        <tbody class="basketList">

        </tbody>
    </table>
    <br>
    <div>
        <button type="button" class="btn btn-outline-primary" style="float:left" onclick="deleteCheck()">선택 삭제</button>
        <button type="button" class="btn btn-outline-primary" style="float:left" onclick="processCheck()">결제 진행</button>
    </div><br><br><br>
    
    <h3>결제 진행</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>강연 번호</td>
                <td>제목</td>
                <td>날짜</td>
                <td>가격</td>
            </tr>
        </thead>
        <tbody class="pay-process">
        </tbody>
    </table>
    <br>

    <div>
        <div class="grid_price">원</div>
        <div class="grid_price totalPrice"></div>
        <div class="grid_price">*총 금액 :&ensp;</div>    
    </div><br><br>

    <div class="buyer_info"></div>
    <div class="pay-btn"></div>

</div>
  


  <script>
    $(document).ready(function(){
        getBasketList();
    });

    function getBasketList(){
        $.getJSON("basket_list.php", function(data){
            console.log(data);
            $(".basketList *").remove();
            $(data).each(function(){

                var checkbox = '<input type="checkbox" class="ckbox" name="ckbox" value='+this.idx+'>';
                var basketList = '<tr><td style="width:10%">'+checkbox+'</td><td>'+this.title+'</td><td>'+this.lectureDay+'</td><td>'+this.price+'</td><td style="width:10%">'+this.idx+'</td></tr>';
                $(".basketList").append(basketList);
                
            });    
        });
    }

    function checkAll(){
        $('.ckbox').prop('checked', true);
    }
    function uncheckAll(){
        $('.ckbox').prop('checked', false);
    }

    function findCheck(){
        var deleteList = new Array;
        $("input:checkbox[name='ckbox']").each(function(){
            if($(this).is(":checked")==true){
                var number = this.value;
                deleteList.push(number);
            }
        })
        return deleteList;
    }

    function deleteCheck(){
        var listReturned = findCheck();
        deleteAjax(listReturned);
    }

    function deleteAjax(listdelete){
        $.ajax({
            type: 'POST',
            url : 'delete_basket.php',
            data : {"deleteList" : listdelete},
            success : function(response){
                if(response=='success'){
                    getBasketList();
                }
            }
        });
    }

    function processCheck(){
        var listReturned2 = findCheck();
        console.log("processCheck()");
        console.log(listReturned2);
        if(listReturned2.length == 0){
            alert('주문하실 상품을 선택해주세요.');
        } else {
            getProcessList(listReturned2);
        }
    }

    $.postJSON = function(url, data, func) { 
        $.post(url+(url.indexOf("?") == -1 ? "?" : "&")+"callback=?", data, func, "json"); 
    } 

    totalPrice; //추후 kakaopay결제를 위한 전역변수
    totalTitle;
    function getProcessList(listProcess){
        console.log("getProcessList()");
        $.ajax({
            type: 'POST',
            url : 'process_basket.php',
            data : {"list" : listProcess},
            success : function(data){
                
                var filtered_data = JSON.parse(data);
                var buyer_name;
                var buyer_uid;
                totalPrice = 0;
                totalTitle = "";
                $(".pay-process *").remove();
                $(filtered_data).each(function(){

                    totalTitle += this.title+' & ';
                    var payList = '<tr><td style="width:10%">'+this.idx+'</td><td>'+this.title+'</td><td>'+this.lectureDay+'</td><td>'+this.price+'</td></tr>';
                    $(".pay-process").append(payList);
                    
                    //가격 계산
                    var filtered_price = parseInt(this.price);
                    totalPrice = totalPrice + filtered_price;

                    //사용자 정보
                    buyer_name = this.name;
                    buyer_uid  = this.uid;
                });   
                console.log(totalPrice);
                $(".totalPrice *").remove();
                $(".buyer_info *").remove();
                $(".pay-btn *").remove();
                $(".totalPrice").append('<p>'+totalPrice+'</p>');
                $(".buyer_info").append('<h5>사용자 정보</h5><ul><li>닉네임 : '+'<?=$uName?>'+'</li><li>아이디 : '+'<?=$uid?>'+'</li></ul>')
                $(".pay-btn").append('<button type="button" class="btn btn-outline-primary" style="float:center" onclick="payProcess()">주문하기</button>');
            }
        });
       
    }
    

    function payProcess(){
        var IMP = window.IMP; // 생략가능
        IMP.init('imp76399867'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용
        var msg;
        
        IMP.request_pay({
            pg : 'kakaopay',
            pay_method : 'card',
            merchant_uid : 'merchant_' + new Date().getTime(),
            name : totalTitle,
            amount : totalPrice,
            buyer_email : '<?=uid?>',
            buyer_name : '<?=uName?>',
            buyer_tel : '01012345678',
            buyer_addr : '남성역 1번 출구',
            buyer_postcode : '123-456',
            //m_redirect_url : 'http://www.naver.com'
        }, function(rsp) {
            if ( rsp.success ) {
                //[1] 서버단에서 결제정보 조회를 위해 jQuery ajax로 imp_uid 전달하기
                jQuery.ajax({
                    url: "/payments/complete", //cross-domain error가 발생하지 않도록 주의해주세요
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        imp_uid : rsp.imp_uid
                        //기타 필요한 데이터가 있으면 추가 전달
                    }
                }).done(function(data) {
                    //[2] 서버에서 REST API로 결제정보확인 및 서비스루틴이 정상적인 경우
                    if ( everythings_fine ) {
                        msg = '결제가 완료되었습니다.';
                        msg += '\n고유ID : ' + rsp.imp_uid;
                        msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                        msg += '\결제 금액 : ' + rsp.paid_amount;
                        msg += '카드 승인번호 : ' + rsp.apply_num;
                        
                        alert(msg);
                        
                    } else {
                        //[3] 아직 제대로 결제가 되지 않았습니다.
                        //[4] 결제된 금액이 요청한 금액과 달라 결제를 자동취소처리하였습니다.
                    }
                });
                //결제 내역 db에 저장(위의 if문 안에서 하는게 맞는데 지금은 테스트 버전이라..)
                
                //성공시 이동할 페이지
                var listOrdered = findCheck();
                add_orderList(listOrdered);
                //deleteAjax(listOrdered);
                location.href='success_payment.php';
            } else {
                msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
                //실패시 이동할 페이지
                location.href="fail_payment.php";
                alert(msg);
            }
        });
        
    };

    function add_orderList(orderlist){
        console.log('add_orderList()');
        $.ajax({
            type: 'POST',
            url : 'add_orderList.php',
            data : {"orderList" : orderlist},
            success : function(response){
                if(response=='success'){
                    console.log('add_orderList() success');
                }
            }
        });
    }
  </script>

  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>