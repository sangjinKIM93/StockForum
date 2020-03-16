<?php
$idx = $_GET['idx'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM diary_list where idx='$idx'";
$result= mysqli_query($conn, $sql);
$fetch = mysqli_fetch_array($result);

$deal_idx = $fetch['deal_idx'];

$sqlStock = "SELECT * FROM deal_list where idx='$deal_idx'";
$resultStock= mysqli_query($conn, $sqlStock);
$fetchStock = mysqli_fetch_array($resultStock);
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
        <div style="border-bottom: 1px solid LightGray; padding:7px" >
            <?=$fetch['title']?>
        </div>
        <div style="text-align: right">작성일 : <?=$fetch['created']?></div><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>구분</td>
                    <td>종목명</td>
                    <td>수량</td>
                    <td>가격</td>
                    <td>총액</td>
                    <td>손익</td>
                    <td>매매일</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                    <?php if($fetchStock['state']==1){ 
                        $profit="";?>
                        매수
                    <?php }elseif($fetchStock['state']==2){ 
                        $profit = $fetchStock['total']-($fetchStock['priceAvg']*$fetchStock['num']);
                        ?>
                        매도
                    <?php }else{ ?>
                        단상
                    <?php }?>
                    </td>
                    <td><?=$fetchStock['name']?></td>
                    <td><?=$fetchStock['num']?></td>
                    <td><?=number_format($fetchStock['price'])?></td>
                    <td><?=number_format($fetchStock['total'])?></td>
                    <td><?=number_format($profit)?></td>
                    <td><?=$fetchStock['created']?></td>
                </tr>
            </tbody>
        </table>
        <textarea style="border: 1px solid LightGray; padding:7px; border-radius: 7px; height:300px; width:100%" ><?=$fetch['content']?></textarea><br>

        <form action="memo_edit.php" method="post">
            <input type="hidden" name="idx" value="<?=$idx?>">
            <input type="submit" value="수정" class="btn btn-outline-primary" style="float:right">
        </form>
        <form action="memo_delete.php" method="post">
            <input type="hidden" name="idx" value="<?=$idx?>">
            <input type="submit" value="삭제" class="btn btn-outline-primary" style="float:right">
        </form>

        <button class="btn btn-warning" style="float:left" onclick="location.href='principle.php?idx='+<?=$idx?>">원칙과 연결하기</button>
        
    </div>
    <script>
        function popup(idx){
        var url = "principle.php?idx="+idx;
        var name = "principle";
        var option = "width = 750, height = 500, top=80, left=550, location=no";
        window.open(url, name, option);
        }
    </script>

       <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>