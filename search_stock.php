<?php
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$name = $_POST['name'];
$sql = "SELECT * FROM stock where name like '%$name%'";
$result= mysqli_query($conn, $sql);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/heroic-features.css" rel="stylesheet">

</head>
<body>

    <table class="table table-hover">
        <thead>
            <tr>
                <td>종목코드</td>
                <td>종목명</td>
            </tr>
        </thead>
        <tbody>
            <?php while($fetch = mysqli_fetch_array($result)){ ?>
            <tr>
                <td><?=$fetch['num']?></td>
                <td><?=$fetch['name']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
   <!-- Bootstrap core JavaScript -->
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html> 