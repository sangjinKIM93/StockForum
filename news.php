<?php
include 'simple_html_dom.php';

$html = file_get_html('https://www.youtube.com/results?search_query=%EC%A3%BC%EC%8B%9D+%EA%B3%B5%EB%B6%80');
//echo $html;

//동영상 시간 뽑기(근데 이 경로는 20개까지 밖에 없다잉)
$times = $html->find('span[class=accessible-description]');
$video_time = array();
foreach($times as $k){  
  $k = $k->innertext;
  $timespan = substr($k, 10);
  array_push($video_time, $timespan);
}

//제목과 링크 & 링크로 썸네일 뽑기
$a = $html->find('a[class=yt-uix-tile-link yt-ui-ellipsis yt-ui-ellipsis-2 yt-uix-sessionlink      spf-link]');
$links = array();
$titles = array();
foreach($a as $b){

    $href = $b->href;
    $filtered_href = 'https://www.youtube.com'.$href;
    $b->href = $filtered_href;
    array_push($links, $filtered_href);

    $title = $b->innertext;
    array_push($titles, $title);

}
$thumbnails = array();
for($i=0; $i<20; $i++){

    $video_id = explode("?v=", $links[$i]);
    $video_id = $video_id[1];
    $thumbnail = "http://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
    array_push($thumbnails, $thumbnail);
}

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
    <style>
      .timeTag{
        position:absolute; 
        top:67%;
        left:5%;
        background-color:black;
        color: white;
        border-radius: 3px;
      }
      #titleLine{
      line-height: 1.5em;
      max-height: 3em;
      display: -webkit-box;
      overflow: hidden;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
      font-weight: bolder;
      }
    </style>
</head>
<body>
  <!-- Navigation -->
  <?php include 'menubar.php'; ?>
  
    <div class="container text-center">
        <h3 style="text-decoration:underline; text-underline-position:under">주식 관련 영상 자료</h3><br>
        <div class="row d-flex flex-wrap" id="lectureList"  >
            <?php for($j=0; $j<20; $j++){?>
            <div class="card btn btn-outline-light text-dark" onclick="popup('<?=$links[$j]?>')" style="width:345px; height:400px; margin:17px">
            
            <img src="<?=$thumbnails[$j]?>" alt="Card image cap" style="width:100%; height:75%; position:realative; border-radius: 5px;" >  
            <div class= timeTag><?=$video_time[$j]?></div> 
               
            <br><p id="titleLine"><?=$titles[$j]?></p>
            </div>
            <?php } ?>
        </div>
    </div>
    
   <script>
    function popup(idx){
        var url = idx;
        var name = "popup.test";
        var option = "width = 650, height = 600, top=50, left=350, location=no";
        window.open(url, name, option);
      }
   </script>

   <!-- Bootstrap core JavaScript -->
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html> 