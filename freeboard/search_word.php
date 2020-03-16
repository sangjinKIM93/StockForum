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
$search_word = $_GET['search_word'];
$field = $_GET['field'];

$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");

$sql_reply = "SELECT * FROM freeboard where $field like '%$search_word%'";
$resultPaging = mysqli_query($conn, $sql_reply);
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
  <h3><?=$writer_name?>검색결과(자유게시판)</h3><br>

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
    $sql_reply = "SELECT * FROM freeboard where $field like '%$search_word%' ORDER BY num DESC LIMIT $start_point,$list";
    $real_data = mysqli_query($conn, $sql_reply);
    $list_count = mysqli_num_rows($real_data);
    if($list_count == 0){
        echo '<h4 style="text-align:center">검색결과가 없습니다.</h3>';
        
    //음.. 아마 검색 결과가 적을때 테이블이 이쁘지 않게 나오는 경우 대비한 것인듯
    }else if($list_count< $list){
        for($i=1; $i<=$list_count; $i++){
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
        
    }else {
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
    }
    ?>
    
    </tbody>
  </table>
    <!-- 페이징 버튼. 부트스트랩 활용 -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="search_word.php?field=<?=$field?>&search_word=<?=$search_word?>&page=<?=$start_page-1?>">이전</a>
        </li>
        <?php
        for($p=$start_page; $p<=$end_page; $p++){
        ?>
        <li class="page-item"><a class="page-link" href="search_word.php?field=<?=$field?>&search_word=<?=$search_word?>&page=<?=$p?>"><?=$p?></a></li>
        <?php
        }
        ?>
        <li class="page-item">
          <a class="page-link" href="search_word.php?field=<?=$field?>&search_word=<?=$search_word?>&page=<?=$end_page+1?>">다음</a>
        </li>
      </ul>
    </nav>

    <!-- 글 검색 -->
    <form method="get">
        <div class="d-flex justify-content-end">
          <div>
            <select name="field" class="form-control" id="">
                  <option value="title">제목</option>
                  <option value="content">내용</option>
                  <option value="name">글쓴이</option>
            </select>
          </div>
          <div>
            <input type="text" name="search_word" class="form-control" placeholder="search">
          </div>
          <div>
            <input type="submit" class="btn btn-primary" id="">
          </div>
        </div>
    </form><br>
    
  </div>

  

  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
