<?php
if(isset($_GET['idx'])){
    $memoIdx = $_GET['idx'];
}else{
    $memoIdx = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- JQuery -->
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/heroic-features.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
</head>
<body>
    <!-- 원칙과 메모 연결하기 에 차이를 주기 위한 변수. php변수를 js에 넘기기 위해서. 다음과 같은 형식 -->
    <input type="hidden" name="memoIdx" id="memoIdx" value="<?=$memoIdx?>">  
    
    <div class="principleList container" >
        <br><br>
        <h3 style="text-align:center; text-decoration:underline; text-underline-position:under;">원숭이보다 뛰어나기 위한 방법</h3><br><br>
        <button class="btn btn-warning" style="float:right" id="listOrder">순서 저장(드래그로 순서 변경 후 버튼 클릭)</button><br>
        <br>
        <ul class="list-group" id="pList">
            
        </ul><br><br><br>
        <form action="create_principle.php" class="form-inline" method="POST" id="form1">
            <input type="text" name="content"class="form-control" maxlength="90" style="width:90%" placeholder="원칙을 추가해주세요."/>
            <input type="submit" value="추가" class="btn btn-warning form-control" style="width:10%" onclick="create_principle(); return false;"/>
        </form><br><br>
        
        
        
    </div>
  

    <script>
    $(document).ready(function(){
        getPrincipleList();
    });

    $(function(){
        $("#pList").sortable();
        $("#pList").disableSelection();
    });

    $('#listOrder').click(function(){
        var list_arr = [];
        $("#pList div").each(function(){
            var id = $(this).attr('id');
            console.log(id);
            list_arr.push(id);
        });

        $.ajax({
            type: 'POST',
            url : 'update_order.php',
            data : {'list_arr' : list_arr},
            success : function(response){
                if(response=='success'){
                    alert("success");
                } else {
                    console.log(response);
                }
            }
        });

    })
    
    memoIdx = $("#memoIdx").val();

    function getPrincipleList(){
        var btnList = "";
        $.getJSON("principle_list.php", function(data){
            $(".list-group *").remove();
            $(data).each(function(){     
                console.log(this.reference);
                //메모와의 연결을 위한 창인지. 수정을 위한 창인지.
                if(memoIdx > 0){
                    btnList = 
                    '<button style="float:right" onclick="connect_principle('+this.idx+')"><i class="fa fa-check"></i></button>';
                } else {
                    btnList = 
                    '<button style="float:right" onclick="delete_principle('+this.idx+')"><i class="fa fa-remove"></i></button>\
                    <button style="float:right" onclick="edit_principle('+this.idx+')"><i class="fa fa-pencil"></i></button>';
                }

                $(".list-group").append('<div id="'+this.idx+'" ><li class="list-group-item" >'+this.content+btnList+'</li></div>');
                
            });    
        });
    }

    function connect_principle(conIdx){
        //버튼 클릭시 디비 칼럼에 memoIdx를 넘겨서 저장. -> ajax
        ///!!근데 이게 json형식으로 저장되어야 할듯. 수정/삭제도 고민해야해.
        //alert로 "더 추가하시겠습니까?" 묻기
        $.ajax({
            type: 'POST',
            url : 'connect_principle.php',
            data : {'idx':conIdx, 'memoIdx':<?=$memoIdx?>},
            success : function(response){
                if(response=='success'){
                    opener.getPrincipleList();
                    alert("success");
                } 
            }
        });

    }

    function create_principle(){
        console.log("create_principle()");
        var list_num = 1;
        $("#pList div").each(function(){
            list_num++
        });
        console.log("list_num");
        console.log(list_num);
        //리스트의 갯수를 10개로 제한
        if(list_num < 11){
            var formData = $("#form1").serialize();
            $.ajax({
                type: 'POST',
                url : 'create_principle.php',
                data : formData,
                success : function(response){
                    if(response=='success'){
                        //alert("success");
                        getPrincipleList();
                    } else {
                        console.log(response);
                    }
                }
            });
        }else{
            alert("원칙은 10개까지만 등록이 가능합니다.");
        }
    }

    function delete_principle(num_principle){
        console.log("delete_principle()");
        var result = confirm("정말로 삭제 하시겠습니까?");
        if(result){
            $.ajax({
                type: 'POST',
                url : 'delete_principle.php',
                data : {'idx' : num_principle},
                success : function(response){
                    if(response=='success'){
                        getPrincipleList();
                    } else {
                        console.log(response);
                    }
                }
            });
        }
    }

    function edit_principle(idxEdit){
        console.log("edit_principle()");
        var pre_data = $('#'+idxEdit).children('.list-group-item').text();
        console.log(pre_data);
        $("#"+idxEdit+" *").remove();
        var editForm = 
        '<li class="list-group-item"><form class="container form-inline" id="edit'+idxEdit+'">\
            <input type="hidden" name="idx" value="'+idxEdit+'">\
            <input type="text" class="form-control form-group" maxlength="90" style="width:87%" name="content" value="'+pre_data+'">&ensp;&ensp;\
            <input type="submit" class="btn btn-primary form-group" style="float:right" onclick="edit_process('+idxEdit+'); return false;" value="완료">\
        </form></li>'
        $('#'+idxEdit).append(editForm);
    }

    function edit_process(idxEditProcess){
        var formData = $("#edit"+idxEditProcess).serialize();
        console.log("edit_process()");
        $.ajax({
            type: 'POST',
            url : 'edit_process.php',
            data : formData,
            success : function(response){
                if(response=='success'){
                    getPrincipleList();
                } else {
                    console.log(response);
                }
            }
        });
    }

    function popup(idx){
      var url = "reference_view.php?idx="+idx;
      var name = "reference_view";
      var option = "width = 650, height = 500, top=50, left=250, location=no";
      window.open(url, name, option);
    }
    </script>

  
  <!-- Bootstrap core JavaScript -->
  <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>