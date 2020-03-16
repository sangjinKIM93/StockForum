<?php
session_start();
$uid = $_SESSION['id'];
//해당 아이디로 열린 강연 idx 가져오기
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql_idx = "SELECT * FROM lectureboard where uid = '$uid'";
$result_idx= mysqli_query($conn, $sql_idx);
$fetch =  mysqli_fetch_all($result_idx, MYSQLI_ASSOC);

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
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    

</head>
<body>
    <!-- Navigation -->
  <?php include 'menubar_lecture.php'; ?>
  <div class="container">
    <h4 style="text-align:center">나의 클래스</h4><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>제목</td>
                <td>날짜</td>
                <td>강의 생성일</td>
                <td>신청 인원</td>
                <td>세부 상황</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($fetch as $target): 
            $target_idx = $target['idx'];
       
            $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
            $sql = "SELECT * FROM order_list where lec_idx = $target_idx";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_num_rows($result);
        ?>
            <tr>
                <td><?=$target['title']?></td>
                <td><?=$target['lectureDay']?></td>
                <td><?=$target['created']?></td>
                <td><?=$row?></td>
                <td>
                    <button class="btn btn-primary" onclick="popup(<?=$target_idx?>)">신청 현황</button>
                </td>
            </tr>
        <?php endforeach; ?> 
            
        </tbody>
    </table>
  </div>

  
  
    
  <script>
  function popup(idx){
      var url = "my_lectureDetail.php?idx="+idx;
      var name = "popup.test";
      var option = "width = 650, height = 600, top=50, left=350, location=no";
      window.open(url, name, option);
    }
  </script>
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>