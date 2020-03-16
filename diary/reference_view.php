<?php
session_start();
$uid = $_SESSION['id'];
$idx = $_GET['idx'];
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT reference from principle where idx = $idx and uid='$uid'";
$result = mysqli_query($conn, $sql);
$fetch = mysqli_fetch_array($result);

$pre_Array = $fetch['reference'];
$pre_Array = json_decode($pre_Array);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>구분</td>
                    <td>제목</td>
                    <td>날짜</td>
                    <td>삭제</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($pre_Array as $memo){
                    $memoResult = mysqli_query($conn, "SELECT * FROM diary_list where idx=$memo and uid='$uid'");
                    $memoFetch = mysqli_fetch_array($memoResult);
                    $state = "";
                    if($memoFetch['state']==1){
                        $state = "매수";
                    }else if($memoFetch['state']==2){
                        $state = "매도";
                    }
                ?>
                <tr>
                    <td><?=$state?></td>
                    <td onclick="location.href='memo_view.php?idx=<?=$memo?>'" style="cursor:pointer"><?=$memoFetch['title']?></td>
                    <td><?=$memoFetch['created']?></td>
                    <td><button onclick="removeRefer(<?=$memo?>)"><i class="fa fa-remove"></i></button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <script>
        function removeRefer(memoIdx){
            var result = confirm("정말로 삭제하시겠습니까?");
            if(result){
                $.ajax({
                    type: 'POST',
                    url : 'delete_refer.php',
                    data :{'memoIdx':memoIdx, 'princlipleIdx':<?=$idx?>},
                    success : function(response){
                        if(response=='success'){
                            location.reload();
                            opener.getPrincipleList();
                        }else{
                            console.log(response);
                        } 
                    }
                });
            }
        }
        
    </script>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>