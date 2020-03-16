<?php
    session_start();
    $uid = $_SESSION['id'];
    $uName = $_SESSION['name'];
    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $idx = $_GET['idx'];
    $sqlNum = "SELECT * FROM lectureboard Where idx = '$idx' ";  //이게 수행되었을까?
    $result = mysqli_query($conn, $sqlNum);  //이게 작동했을까? 
    $data = mysqli_fetch_array($result);
    $url = "lecture_edit.php?idx=".$idx;

    //조회수 처리
    if(isset($_COOKIE["lecture_hit"])){
        $lecture_hit = $_COOKIE["lecture_hit"];
    }else {
        $lecture_hit = "";
    }

    $name = $data['name'];
    $tmp = "/".$idx."_".$name."/i";      //preg_match의 인식 형식이야. /target/i
    if(preg_match($tmp, $lecture_hit)){

    }else{
        $query_hit = "UPDATE lectureboard SET hits=hits+1 where idx='$idx'";
        $result_hit = mysqli_query($conn, $query_hit);
        $tmp = $tmp.$lecture_hit;
        setcookie("lecture_hit", $tmp, time()+86400, "/");
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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/heroic-features.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
    #imgDisplay{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        border-radius: 10px;
        
    }
    </style>

</head>

<body>
    <div class="container">
        
        <div style="border-bottom: 1px solid LightGray; overflow:hidden; word-wrap:break-word"><h3><?=$data['title']?></h3></div>
        <p style="text-align:left">글쓴이: <?=$data['name']?> &ensp;/&ensp; 조회수 :<?=$data['hits']?> </p>
        <img src="file_uploads/<?=$data['imageFile']?>" id="imgDisplay"/><br>
        <!-- 세부 사항 -->
        <h6>요약 정보</h6>
            <ul style="border: 1px solid LightGray; border-radius: 7px">
                
                <?php if($data['finished'] == 'on'){ ?>  
                <p style="color:red;">[모집마감!]</p>       
                <?php }else{ ?>
                <li>강의 날짜: <?=$data['lectureDay']?>&ensp;&ensp;<?=$data['startTime']?>~<?=$data['endTime']?></li>
                <?php } ?>
                
                <li>강의 장소 : <?=$data['address']?> / <?=$data['addressDetail']?></li>
                <li>최대 인원 : <?=$data['limitation']?></li>
                <li>가격 : <?=$data['price']?></li>
            </ul>
        <!-- 지도 -->
        <?php if($data['address'] != ''){ ?>  
            <div id="map" style="width:100%;height:150px;"></div>
        <?php } ?>  

        <!-- content -->
        <h6>세부 정보</h6>
        <div style="border: 1px solid LightGray; padding:7px; border-radius: 7px" >
            <?=$data['content']?>
        </div><br>

        <!-- 버튼(목록, 삭제, 수정) -->
        <?php if($uid == $data['uid']) { ?>
            <div>
                <button type="button" class="btn btn-outline-primary" style="float:right" onclick="location.href='<?=$url?>'">수정</button>
                <form action="delete_lecture.php" method="post">
                    <input type="hidden" name="idx" value="<?=$data['idx']?>">
                    <input type="hidden" name="imageFile" value="<?=$data['imageFile']?>">
                    <input type="submit" value="삭제" class="btn btn-outline-primary" style="float:right">
                </form>
            </div><br><br>
        <?php }else{ 
                   if($data['finished'] == 'on'){?>
                   <p style="text-align: right; color:red">마감된 강연입니다.</p>
            <?php }else{?>
            <div>
                <form action="basket_add.php" method="post" onsubmit="alert('장바구니에 추가되었습니다.')">
                    <input type="hidden" name="idx" value="<?=$data['idx']?>">
                    <input type="hidden" name="title" value="<?=$data['title']?>">
                    <input type="hidden" name="lectureDay" value="<?=$data['lectureDay']?>">
                    <input type="submit" value="장바구니 추가" class="btn btn-outline-primary" style="float:right">
                </form>
                <form action="direct_order.php" method="post">
                    <input type="hidden" name="idx" value="<?=$data['idx']?>">
                    <input type="hidden" name="title" value="<?=$data['title']?>">
                    <input type="hidden" name="lectureDay" value="<?=$data['lectureDay']?>">
                    <input type="submit" value="바로 주문" class="btn btn-outline-primary" style="float:right">
                </form>
            </div><br><br>
        <?php }} ?>
    
    </div>

    <!-- 지도 기능 -->
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=31734a1ac8920a6305964238460b8948&libraries=services"></script>
    <script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
        mapOption = {
            center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };  

    // 지도를 생성합니다    
    var map = new kakao.maps.Map(mapContainer, mapOption); 

    // 주소-좌표 변환 객체를 생성합니다
    var geocoder = new kakao.maps.services.Geocoder();

    // 주소로 좌표를 검색합니다
    geocoder.addressSearch('<?=$data['address']?>', function(result, status) {

        // 정상적으로 검색이 완료됐으면 
        if (status === kakao.maps.services.Status.OK) {

            var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

            // 결과값으로 받은 위치를 마커로 표시합니다
            var marker = new kakao.maps.Marker({
                map: map,
                position: coords
            });

            // 인포윈도우로 장소에 대한 설명을 표시합니다
            var infowindow = new kakao.maps.InfoWindow({
                content: '<div style="width:150px;text-align:center;padding:6px 0;">강연 장소</div>'
            });
            infowindow.open(map, marker);

            // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
            map.setCenter(coords);
        } 
    });    
    </script>

     <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

