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
  
    <!-- ckeditor -->
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

</head>
<body>
<!-- navigation -->
<?php include 'menubar_freeboard.php'; ?>

    <div class="container">
        <h5>자유 게시판(글쓰기)</h5><br>

        <form action="process-articleWrite.php" method="POST">
            <p><input type="text" name="title" placeholder="제목을 입력하세요." class="form-control"></p>
            <textarea name="content" id="editor"></textarea>
            <script>
                CKEDITOR.replace('editor', {
                    height:300,
                    filebrowserUploadUrl:'upload.php'
                });
            </script><br>
            <p><input type="submit" class="btn btn-primary" value="완료" style="float: right"></p><br>
            
        </form>
    </div>
</body>
</html>