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

    <!-- include libraries(jQuery, bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 

    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
    });
    </script>
    <style>
    #grid-content{
        border:1px solid grey;
        display:grid;
        
    }
    </style>
</head>
<body>
<!-- navigation -->
<?php include 'menubar_freeboard.php'; ?>

    <?php
    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $num = $_GET[num];
    $sqlNum = "SELECT * FROM freeboard Where num = '$num'";  //이게 수행되었을까?
    $result = mysqli_query($conn, $sqlNum);  //이게 작동했을까?
    $data = mysqli_fetch_array($result)
    
    ?>

    <div class="container">
        <h3>글 수정</h3><br>
        <form action="process-edit.php" method="POST">
            <input type="hidden" name="num" value="<?=$num?>">
            <p><input type="text" name="title" value="<?=$data['title']?>" class="form-control"></p>
            <p><textarea id="summernote" name="content"><?=$data['content']?></textarea></p>
            <p><input type="submit" value="완료" style="float: right"></p>
            <button type="button" class="btn btn-primary" style="float:left">이미지 첨부</button>
        </form>
    </div>

</body>
</html>