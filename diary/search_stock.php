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


</head>
<body>
<div class="container">
    <h5>종목 검색</h5>
    <form action="process_search_stock.php" method="post" id="form_search">
    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="name" class="form-control" id="name">
        </div>
        <div class="form-group col-3">
            <input type="submit" class="form-control btn btn-primary" value="검색" onclick="search_stock(); return false;">
        </div>
    </div>
    </form>

    <table class="table table-hover table_search">
        <thead>
            <tr>
                <td>종목번호</td>
                <td>종목명</td>
            </tr>
        </thead>
        <tbody class="result_search">
            <tr>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
    
<script>
    function search_stock(){
        var value = $('#name').val();
        $.getJSON("process_search_stock.php?name="+value, function(data){
            console.log(data);
            $(".result_search *").remove();
            $(data).each(function(){
            var filtered_name = "'"+this.name+"'";
            var filtered_num = "'"+this.num+"'";
            var list_search='<tr onclick="send_value('+filtered_name+','+filtered_num+')" style="cursor:pointer">\
                                <td>'+this.num+'</td>\
                                <td>'+this.name+'</td>\
                            </tr>';
                
                $(".result_search").append(list_search);     
            });    
        });
    }

    function send_value(value_name, value_num){
        console.log("send_value();");
        console.log(value_name);
        window.opener.document.getElementById("name").value=value_name;
        window.opener.document.getElementById("stockNum").value=value_num;
        close();
    }
</script>
    
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html> 