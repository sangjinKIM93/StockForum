<?php
session_start();
$uid = $_SESSION['id'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql = "SELECT * FROM current_stock where uid='$uid'";
$result= mysqli_query($conn, $sql);
$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
  
</head>
<body>
<!-- Navigation -->
<?php include 'menubar_diary.php'; ?>
<div class="container">
<div class="container">
    <h5>매수 일기</h5><br>
    <button class="btn btn-outline-primary" onclick="select_new()">매수(새로운 종목)</button>
    <button class="btn btn-outline-primary" onclick="select_pre()">추가매수(기존 종목)</button>
    <br><br>
    <form action="process-articleWrite.php" method="POST">
        <div class="inputForm">
        <!-- 추가 매수 밑작업 -->
        <!-- 매수 밑작업 -->
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>구분</td>
                    <td>종목명</td>
                    <td>수량</td>
                    <td>가격</td>
                    <td>총액</td>
                </tr>
            </thead>
            <thead class="json_container">

            </thead>
        </table>

        <p><input type="text" name="title" placeholder="제목을 입력하세요." class="form-control"></p>
        <textarea name="content" id="editor" class="form-control" style="height:400px" placeholder="내용을 입력하세요."></textarea><br>
        <p><input type="submit" class="btn btn-primary" value="완료" style="float: right"></p><br>
    </form>

    <button class="btn btn-outline-primary" onclick="add_buy()">test</button>

</div>

  <script>
    inputArray = new Array();   //json 추가를 위한 전역변수
    function json_new(){
        console.log('json_new()');
        var inputInfo = new Object();
        inputInfo.name = document.getElementById("name").value;
        inputInfo.num = document.getElementById("num").value;
        inputInfo.price = document.getElementById("price").value;
        inputInfo.state = document.getElementById("state").value;
        inputArray.push(inputInfo);
        var obj_total = inputInfo.price*inputInfo.num;
        
        var json_obj = 
                '<tr>\
                    <td>'+filterState(inputInfo.state)+'</td>\
                    <td>'+inputInfo.name+'</td>\
                    <td>'+inputInfo.num+'</td>\
                    <td>'+inputInfo.price+'</td>\
                    <td>'+obj_total+'</td>\
                </tr>'
        $(".json_container").append(json_obj);
        console.log(inputInfo);
        console.log(inputArray);
    }

    function filterState(stat){
        if(stat=='1'){
            return '신규매수';
        } else {
            return '추가매수';
        }
    }

    //입력된 종목들 db 처리
    function add_buy(){
        console.log('json_new()');
        
        for(i=0; i<inputArray.length; i++){
        var inputArray_str = JSON.stringify(inputArray[i]);
        console.log('jsonArray');
        $.ajax({
            type: 'POST',
            url : 'add_buy.php',
            data :{inputArray_str:inputArray_str},
            success : function(response){
                if(response=='success'){
                    console.log('jsonArray success!');
                } else {
                    console.log('응답을 여기서 확인한다.');
                    console.log(response);
                }
            }
        });
        }
    }

    function select_new(){
        console.log('select_new()');
        var new_btn= '<div class="form-group col-1"><label for="inputPassword4">&ensp;</label><input type="submit" class="form-control btn btn-primary" value="제출" placeholder="Password" onclick="json_new(); return false;"></div>';
        var new_form = '<form id="form1"><input type="hidden" id="state" value="1"><div class="form-row"><div class="form-group col"><label for="inputEmail4">종목 이름</label><input type="text" id="name" class="form-control" name="name" placeholder="이름"></div><div class="form-group col-2"><label for="inputPassword4">수량</label><input type="text" id="num" class="form-control" name="num" placeholder="수량"></div><div class="form-group col"><label for="inputPassword4">매수 가격</label><input type="text" id="price" class="form-control" name="price" placeholder="가격"></div>'+new_btn+'</div></form>';
        
        $(".inputForm *").remove();
        $(".inputForm").append(new_form);
    }
    function select_pre(){
        var pre_btn= '<div class="form-group col-1"><label for="inputPassword4">&ensp;</label><input type="submit" class="form-control btn btn-primary" value="제출" placeholder="Password" onclick="json_new(); return false;"></div>';
        var name_select = '<input type="hidden" id="state" value="2"><select name="field" class="form-control" id="name"><?php foreach($fetch as $target): ?><option value="<?=$target['name']?>"><?=$target['name']?></option><?php endforeach; ?> </select>';
        var pre_form = '<form id="form1"><input type="hidden" id="state" value="2"><div class="form-row"><div class="form-group col"><label for="inputEmail4">종목 이름</label>'+name_select+'</div><div class="form-group col-2"><label for="inputPassword4">수량</label><input type="text" id="num" class="form-control" name="num" placeholder="수량"></div><div class="form-group col"><label for="inputPassword4">매수 가격</label><input type="text" id="price" class="form-control" name="price" placeholder="가격"></div>'+pre_btn+'</div></form>';
        $(".inputForm *").remove();
        $(".inputForm").append(pre_form);
    }
  </script>
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
