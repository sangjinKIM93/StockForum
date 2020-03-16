<!-- 날짜 변환 함수 -->
<?php include './include/dateTransformer.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Quant-Forum</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/heroic-features.css" rel="stylesheet">
  <style>
    #grid-content{
      /* border:1px solid grey; */
      display:grid;
      grid-template-columns: 1fr 1fr;
    }
    .jumbotron{
      padding: 40px;
    }
  </style>
  <script>
        function getCookie(name) {
        var Found = false
        var start, end
        var i = 0
        while(i <= document.cookie.length) {
            start = i
            end = start + name.length
            
            if(document.cookie.substring(start, end) == name) {
            Found = true
            break 
            }
            i++
        }
            if(Found == true) {
            start = end + 1
            end = document.cookie.indexOf(";", start)
            if(end < start)
                end = document.cookie.length
            return document.cookie.substring(start, end)
            }
            return ""
        } 
 
        // popup //
        var noticeCookie = getCookie("name");  // 쿠기 가져오기
        if (noticeCookie != "value"){                
        // 팝업창 띄우기
        window.open('popup.html', 'popup', 'width=500, height=500, top=100, left=100, location=no, status=no, scrollbars= 0, toolbar=0, menubar=no');
        } 
    </script>
</head>
<body>
  <!-- 메뉴바 -->
<?php include 'menubar.php'; ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Jumbotron Header -->
    <header class="jumbotron">
    <h3 class="display-3">Welcome to Stock Forum!</h3>
      <p class="lead">저희 주식 포럼은 투자 일기 서비스를 제공하고<br> 자유 게시판을 통하여 퀀트 투자 관련 다양한 의견을 공유할 수 있습니다.</p>
      <!-- <a href="#" class="btn btn-primary btn-lg">Call to action!</a> -->
      <br>

      <!-- 최근 올라온 글 & 좋아요가 많은 글 -->
      <div id="grid-content">
        <div style="margin-right:20px">
          <b>최근 올라온 글</b>
          <br><table class="table table-hover">
            <tbody>
              <?php
              $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
              // larger93.dothome.co.kr
              // $sql_grant = "GRANT ALL PRIVILEGES ON *.* 'sangjin'@'%' IDENTIFIED BY 'tkdwls12!@'";
              // $reply_grant= mysqli_query($conn, $sql_grant);
              $sql_new= "SELECT * FROM freeboard ORDER BY num DESC LIMIT 6";
              $reply_new= mysqli_query($conn, $sql_new) or die("Error");
              $total_new= mysqli_num_rows($reply_new);
              for($i=1; $i<$total_new; $i++){
                  $fetch_new = mysqli_fetch_array($reply_new);
                  $title_new = $fetch_new['title'];
                  $date_new = $fetch_new['created'];
                  $filtered_date_new = display_datetime($date_new);
                  $num_new = $fetch_new['num'];
                  $url_new = "./freeboard/view.php?num=".$num_new;
              ?>
              <tr>
                <td><a href=<?=$url_new?>><?=$title_new?></a></td>
                <td><?=$filtered_date_new?></td>
              </tr>
              <?php
              }
              ?>
              
            </tbody>
          </table>
        </div>
        <div style="margin-left:30px">
          <b>좋아요 많은 글</b>
          <table class="table table-hover">
            <tbody>
              
              <?php
              $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
              $sql_new= "SELECT * FROM freeboard ORDER BY likes DESC LIMIT 6";
              $reply_new= mysqli_query($conn, $sql_new) or die("Error");
              $total_new= mysqli_num_rows($reply_new);
              for($i=1; $i<$total_new; $i++){
                  $fetch_new = mysqli_fetch_array($reply_new);
                  $title_new = $fetch_new['title'];
                  $likes = $fetch_new['likes'];
                  $num_new = $fetch_new['num'];
                  $url_new = "./freeboard/view.php?num=".$num_new;
              ?>
              <tr>
                <td><a href=<?=$url_new?>><?=$title_new?></a></td>
                <td><?=$likes?></td>
              </tr>
              <?php
              }
              ?>
              
            </tbody>
          </table>
        </div>
      </div>
    </header>

    <!-- Page Features -->
    <div class="row text-center">

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./img/bulletin-board.jpg" width="500" height="325" alt="">
          <div class="card-body">
            <h4 class="card-title">Free-Board</h4>
            <p class="card-text">퀀트 관련 자유로운 의견 공유</p>
          </div>
          <div class="card-footer">
            <a href="./freeboard/free-board.php" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./img/pie-chart.jpg" width="500" height="325" alt="">
          <div class="card-body">
            <h4 class="card-title">Lecture</h4>
            <p class="card-text">퀀트/주식 강연</p>
          </div>
          <div class="card-footer">
            <a href="./lecture/lecture_main.php" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./img/back-test.png" width="500" height="325" alt="">
          <div class="card-body">
            <h4 class="card-title">Stock-diary</h4>
            <p class="card-text">투자 일기</p>
          </div>
          <div class="card-footer">
            <a href="back-test.php" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./img/news.jpg" width="500" height="325" alt="">
          <div class="card-body">
            <h4 class="card-title">News</h4>
            <p class="card-text">투자 관련 영상자료</p>
          </div>
          <div class="card-footer">
            <a href="news.php" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
