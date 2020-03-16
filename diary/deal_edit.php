<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$uid = $_SESSION['id'];
$idx = $_GET['idx'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql= "SELECT * FROM deal_list where idx ='$idx' and uid='$uid'";
$result= mysqli_query($conn, $sql);
$fetch = mysqli_fetch_array($result);

//datepicker 초기값 설정을 위한 변수
$initialDate = $fetch['created'];
$initialDate = strtotime($fetch['created']);    //str -> time
$initialDate = date('Y/m/d', $initialDate);     //time -> str(내가 원하는 형식)

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

    <!-- jquery for DatePicker -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- datepicker -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

</head>
<body>
<div class="container">
    <h4>매수/매도 기록</h4>
    <form action="edit_deal.php" method="post">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td style="width:15%">구분</td>
                <td style="width:25%">종목명</td>
                <td>수량</td>
                <td>가격</td>
                <td>날짜.</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" name="state" id="state">
                        <option value="1">매수</option>
                        <option value="2">매도</option>
                    </select>
                </td>
                <td><input type="text" id="sellName" class="form-control" name="name" value="<?=$fetch['name']?>"></td>
                <td><input style="IME-MODE: disabled"  type="number"  id="sellNum" class="form-control" name="num" value="<?=$fetch['num']?>"></td>
                <td><input style="IME-MODE: disabled"  type="number" class="form-control" name="price" value="<?=$fetch['price']?>"></td>
                <td><input type="text" class="form-control datepicker" id="datepicker" name="day" placeholder="click here!"/></td>
            </tr>
        </tbody>
    </table><br>
        <input type="hidden" name="idx" value="<?=$idx?>">
        <input type="submit" class="btn btn-primary" style="float:right" value="완료">
    </form>

    
</div>
  <script>
    //select 초기값 셋팅
    $('#state option[value='+<?=$fetch['state']?>+']').attr('selected', true);

    //datepicker 설정.
    $("#datepicker").datepicker({dateFormat:'yy/mm/dd'});
    $("#datepicker").datepicker('setDate', '<?=$initialDate?>');

    //매도를 선택했을 경우 num 제한걸기
    $(document).on("keyup", "input[id^=sellNum]", function() {
        var state = $("#state option:selected").val();
        if(state == 2){
            var val= $(this).val();
            var name = String($("#sellName").val());
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
        } 
    });
  </script>
    
    <!-- Bootstrap core JavaScript -->
  <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>