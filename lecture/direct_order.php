<?php
session_start();
$uid = $_SESSION['id'];
$uName = $_SESSION['name'];

$lec_idx = $_POST['idx'];
$title = $_POST['title'];
$lectureDay = $_POST['lectureDay'];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql = "SELECT * FROM lectureboard WHERE idx='$lec_idx'";
$result= mysqli_query($conn, $sql);
$fetch = mysqli_fetch_array($result);

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
            <tr>
                <td><?=$lec_idx?></td>
                <td><?=$title?></td>
                <td><?=$lectureDay?></td>
                <td><?=$fetch['price']?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <button type="button" class="btn btn-primary" onclick="payProcesss()">주문하기</button>

</div>
  
  <script>
    function payProcesss(){
        var IMP = window.IMP; // 생략가능
        IMP.init('imp76399867'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용
        var msg;
        
        IMP.request_pay({
            pg : 'kakaopay',
            pay_method : 'card',
            merchant_uid : 'merchant_' + new Date().getTime(),
            name : '<?=$title?>',
            amount : '<?=$fetch['price']?>',
            buyer_email : '<?=$uid?>',
            buyer_name : '<?=$uName?>',
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
                add_orderList(<?=$lec_idx?>);
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

    function add_orderList(orderIdx){
        console.log('add_orderList()');
        $.ajax({
            type: 'POST',
            url : 'add_orderList_direct.php',
            data : {"orderIdx" : orderIdx},
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