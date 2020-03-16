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
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$query = "select * from freeboard";
$resultPaging = mysqli_query($conn, $query);
$totalArticle= mysqli_num_rows($resultPaging);

$page = ($_GET['page'])?$_GET['page']:1;

//원하는 블록 갯수와 리스트 갯수를 정한다.
$list = 4;
$block = 3;

$pageNum = ceil($totalArticle/$list);
$blockNum = ceil($pageNum/$block);  //총 볓개의 블록이 있는지. 몇개의 묶음이 있는지.
$nowBlock = ceil($page/$block);   //현재 몇번째 블록인지

//start_page와 end_page를 구한다.
$start_page = (($nowBlock-1)*$block)+1;
if($start_page <= 1){
  $start_page = 1;
}
$end_page = $nowBlock*$block;
if($pageNum <= $end_page){
  $end_page = $pageNum;
}

//게시글 몇분전 표시
function display_datetime($datetime = '')
{
    if (empty($datetime)) {
        return false;
    }

    $diff = time() - strtotime($datetime);

    $s = 60; //1분 = 60초
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $y = $d * 3; //1년 = 1일 * 3일

    if ($diff < $s) {
        $result = $diff . '초전';
    } elseif ($h > $diff && $diff >= $s) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff && $diff >= $h) {
        $result = round($diff/$h) . '시간전';
    } elseif ($y > $diff && $diff >= $d) {
        $result = round($diff/$d) . '일전';
    } else {
    	$result = date('Y.m.d', strtotime($datetime));
    }

    return $result;
}
?>


<div class="container">
  <h3 style="text-decoration:underline; text-underline-position:under; text-align:center">자유게시판</h3>
  <br>

  <!-- 글쓰기 버튼 -->
  <?php
    if(isset($_SESSION["id"])) {
    ?>
      <button type="button" class="btn btn-primary" style="float:right" onclick="location.href='articleWrite.php'">글쓰기</button>
    <?php
    } else {
    ?>
      <p style="float:right">글쓰기는 로그인 후 가능합니다.</p> 
    <?php
    }  
    ?>

  <form method="post">
    <input type="submit" name="date_rank" value="최신순" class="btn btn-outline-primary btn-sm"/>  
    <input type="submit" name="hit_rank" value="조회순" class="btn btn-outline-primary btn-sm"/>
  </form><br>

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
    $start_point = ($page-1)*$list; //해당 페이지 전 페이지가 몇번째 데이터를 불러와서 정해진 list만큼 뽑음
    $real_data = mysqli_query($conn, "SELECT * FROM freeboard ORDER BY num DESC LIMIT $start_point,$list");
    if(isset($_POST['hit_rank'])){
      $real_data = mysqli_query($conn, "SELECT * FROM freeboard ORDER BY hits DESC LIMIT $start_point,$list");
    }
    if(isset($_POST['date_rank'])){
      $real_data = mysqli_query($conn, "SELECT * FROM freeboard ORDER BY num DESC LIMIT $start_point,$list");
    }
    for($i=1; $i<=$list; $i++){
      $fetch = mysqli_fetch_array($real_data);
      $num = $fetch['num'];
      $title = $fetch['title'];
      $name = $fetch['name'];
      $created = $fetch['created'];
      $filtered_created = display_datetime($created);
      $hits = $fetch['hits'];
      $url = "./view.php?num=".$num."&page=".$page;
    ?>
      <tr style="cursor:pointer;"> 
        <td><?=$num?></td>
        <td><a href=<?=$url?>><?=$title?></a></td>
        <td><?=$name?></td>
        <td><?=$filtered_created?></td>
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
          <a class="page-link" href="free-board.php?page=<?=$start_page-1?>">이전</a>
        </li>
        <?php
        for($p=$start_page; $p<=$end_page; $p++){
        ?>
        <li class="page-item"><a class="page-link" href="free-board.php?page=<?=$p?>"><?=$p?></a></li>
        <?php
        }
        ?>
        <li class="page-item">
          <a class="page-link" href="free-board.php?page=<?=$end_page+1?>">다음</a>
        </li>
      </ul>
    </nav>
    <!-- 글 검색 -->
    <form action="search_word.php" method="get">
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
