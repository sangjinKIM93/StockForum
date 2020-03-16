<?php
if(isset($_GET['idx'])){ 
    $idx = $_GET['idx'];
} 
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
</head>
<body>
    <div class="container">
        <h5>메모 작성</h5>
        <form action="process_memo.php" method="post">
            <?php if(isset($idx)){ ?>
            <input type="hidden" name="deal_idx" value="<?=$idx?>">
            <?php } ?>
            <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요."><br>
            <textarea name="content" class="form-control" style="height:300px" placeholder="내용을 입력하세요."></textarea>
            <br><input type="submit" class="btn btn-primary" value="완료" style="float:right"/>
        </form>
    </div>

       <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>