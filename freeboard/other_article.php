<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Quant-Forum</title>
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/heroic-features.css" rel="stylesheet">
  <style>
    #grid-content{
      border:1px solid grey;
      display:grid;
      grid-template-columns: 5fr 1fr;
    }
  </style>
</head>
<body>
<!-- Navigation -->
<?php include 'menubar_freeboard.php'; ?>

<!-- 페이징을 위한 변수들 설정 -->
<?php
$writer_name = $_GET['name'];   //받아온 이름

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$query = "SELECT * FROM freeboard where name='$writer_name'";
$resultPaging = mysqli_query($conn, $query);
$totalArticle= mysqli_num_rows($resultPaging);

$page = ($_GET['page'])?$_GET['page']:1;
$list = 4;
$block = 3;

$pageNum = ceil($totalArticle/$list);
$blockNum = ceil($pageNum/$block);
$nowBlock = ceil($page/$block);

$start_page = (($nowBlock-1)*$block)+1;
if($start_page <= 1){
  $start_page = 1;
}
$end_page = $nowBlock*$block;
if($pageNum <= $end_page){
  $end_page = $pageNum;
}


?>


<div class="container">
  <h3><?=$writer_name?> 님의 글</h3><br>
  <form method="post">
    <input type="submit" name="hit_rank" value="조회순" style="float:right" class="btn btn-secondary btn-sm"/>
    <input type="submit" name="date_rank" value="최신순" style="float:right" class="btn btn-secondary btn-sm"/>
  </form>
  <br><br>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>번호</th>
        <th>제목</th>
        <th>작성자</th>
        <th>날짜</th>
        <th>조회수</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $start_point = ($page-1)*$list;
    $real_data = mysqli_query($conn, "SELECT * FROM freeboard where name='$writer_name' ORDER BY num DESC LIMIT $start_point,$list");
    if(isset($_POST['hit_rank'])){
      $real_data = mysqli_query($conn, "SELECT * FROM freeboard where name='$writer_name' ORDER BY hits DESC LIMIT $start_point,$list");
    }
    if(isset($_POST['date_rank'])){
      $real_data = mysqli_query($conn, "SELECT * FROM freeboard where name='$writer_name' ORDER BY num DESC LIMIT $start_point,$list");
    }
    for($i=1; $i<=$list; $i++){
      $fetch = mysqli_fetch_array($real_data);
      $num = $fetch['num'];
      $title = $fetch['title'];
      $name = $fetch['name'];
      $created = $fetch['created'];
      $hits = $fetch['hits'];
      $url = "./view.php?num=".$num;
    ?>
      <tr style="cursor:pointer;"> 
        <td><?=$num?></td>
        <td><a href=<?=$url?>><?=$title?></a></td>
        <td><?=$name?></td>
        <td><?=$created?></td>
        <td><?=$hits?></td>
      </tr>
      <?php
    }
    ?>
    </tbody>
  </table>
    <!-- 페이징 버튼. 부트스트랩 활용 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="other_article.php?name=<?=$writer_name?>&page=<?=$start_page-1?>">이전</a>
        </li>
        <?php
        for($p=$start_page; $p<=$end_page; $p++){
        ?>
        <li class="page-item"><a class="page-link" href="other_article.php?name=<?=$writer_name?>&page=<?=$p?>"><?=$p?></a></li>
        <?php
        }
        ?>
        <li class="page-item">
          <a class="page-link" href="other_article.php?name=<?=$writer_name?>&page=<?=$end_page+1?>">다음</a>
        </li>
      </ul>
    </nav>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
