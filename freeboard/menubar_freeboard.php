<?php
  session_start();
  if(isset($_SESSION["id"]))
  {
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Stock Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="./free-board.php">자유게시판&emsp;&emsp;</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../lecture/lecture_main.php">주식 강연&emsp;&emsp;</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../diary/diary_main2.php">투자일기&emsp;&emsp;</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../news.php">영상 자료&emsp;&emsp;</a>
        </li>
        <li class="nav-item">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</li>
        <li class="nav-item">
          <a class="nav-link" href="../myhome.php"> <?=$_SESSION["name"]?> 's home </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav><br><br>
<?php
  }else{
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Stock Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <!--
        <li class="nav-item active">
          <a class="nav-link" href="#">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        -->
        <li class="nav-item">
          <a class="nav-link" href="./free-board.php">자유게시판&emsp;&emsp;</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../lecture/lecture_main.php">주식 강연&emsp;&emsp;</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../diary/diary_main2.php">투자일기&emsp;&emsp;</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../news.php">영상 자료&emsp;&emsp;</a>
        </li>
        <li class="nav-item">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</li>
        <li class="nav-item">
          <a class="nav-link" href="../login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../register.php">Register</a>
        </li>
      </ul>
    </div>
  </div>
</nav><br><br>
<?php
  }
?>