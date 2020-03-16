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

    <?php
    $idx = $_POST['idx'];

    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $sqlNum = "SELECT * FROM diary_list Where idx = '$idx'";  //이게 수행되었을까?
    $result = mysqli_query($conn, $sqlNum);  //이게 작동했을까?
    $data = mysqli_fetch_array($result)
    
    ?>

    <div class="container">
        <h5>메모 수정</h5>
        <form action="edit_memo.php" method="post">
            <input type="hidden" name="idx" value="<?=$idx?>">
            <input type="text" name="title" class="form-control" value="<?=$data['title']?>"><br>
            <textarea name="content" class="form-control" style="height:400px"><?=$data['content']?></textarea>
            <br><input type="submit" class="btn btn-primary" value="완료" style="float:right"/>
        </form>
    </div>

</body>
</html>