<?php
session_start();
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

if(isset($_POST['deal_idx'])){
    $deal_idx = $_POST['deal_idx'];
    $sql_state = "SELECT * FROM deal_list where idx=$deal_idx";
    $result_sql = mysqli_query($conn, $sql_state);
    $fetch = mysqli_fetch_array($result_sql);
    $state = $fetch['state'];
    $stockName = $fetch['name'];
} else {
    $deal_idx = 0;
    $state = 0;
    $stockName = "";
}
$title = $_POST['title'];
$content = $_POST['content'];




$sql = "
    INSERT INTO diary_list
    (title, content, stockName, uid, name, deal_idx, created, state)
    VALUES(
        '$title',
        '$content',
        '$stockName',
        '{$_SESSION["id"]}',
        '{$_SESSION["name"]}',
        $deal_idx,
        NOW(),
        $state
        )";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <script>
        window.opener.location.reload();
        window.close();
    </script>
</body>
</html>