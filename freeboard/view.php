<?php
    session_start();
    $uidSession = $_SESSION['id'];
    $uName = $_SESSION['name'];

    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $num = $_GET['num'];
    $sqlNum = "SELECT * FROM freeboard Where num = '$num'";  //이게 수행되었을까?
    $result = mysqli_query($conn, $sqlNum);  //이게 작동했을까? 
    $data = mysqli_fetch_array($result);
    $url = "./edit.php?num=".$num;

    //조회수 올리기
    if(isset($_COOKIE["free_hit"])){
        $free_hit = $_COOKIE["free_hit"];
    }else {
        $free_hit = "";
    }

    $uid = $data['uid'];
    $tmp = "/".$num."_".$uid."/i";      //preg_match의 인식 형식이야. /target/i
    if(preg_match($tmp, $free_hit)){

    }else{
        $query_hit = "UPDATE freeboard SET hits=hits+1 where num='$num'";
        $result_hit = mysqli_query($conn, $query_hit);
        $tmp = $tmp.$free_hit;
        setcookie("free_hit", $tmp, time()+86400, "/");
    }

    //날짜 변환
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
            $result = date('Y.m.d.', strtotime($datetime));
        }

        return $result;
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
    #grid-content{
        border:1px solid grey;
        display:grid;
        grid-template-columns: 6fr 2fr;
    }
    #like_img {
        background-size: 60px;
        width: 60px;
        height: 60px;
        background: url('../img/like.png');
    }
    #delete_img{
        background-size: 16px;
        width: 16px;
        height: 16px;
        background: url('../img/delete_s.png');
        border: 0;
        outline: 0;
    }
 
    </style>
</head>
<body>
<!-- navigation -->
<?php include 'menubar_freeboard.php'; ?>

<div class="container">
    <h1 style="border-bottom: 1px solid grey"><?=$data['title'];?></h1>
      날짜 : <?=$data['created'];?> &nbsp;&nbsp;  / &nbsp;&nbsp;  조회수 : <?=$data['hits'];?>
      <br><br>
      <div id="grid-content">
        <!-- 글 내용 -->
        <div style="border-right:1px solid grey;">
            <?=$data['content'];?>
        </div>
        <!-- id, 좋아요 등 기타 사항 -->
        <div>
            <div align="center">
            <p><?=$data['name'];?></p>
            <!-- 좋아요 제한(글 하나당 좋아요 1개) -->
            <?php
                if(isset($_POST['like_btn'])){
                    //만약 좋아요 누른 기록이 있다면
                    
                    $query_liked = "SELECT * FROM freeboard_like WHERE con_num = $num";
                    $result_liked = mysqli_query($conn, $query_liked);
                    $fetch_liked = mysqli_fetch_array($result_liked);
                    $liked_idx = $fetch_liked['idx'];
                    if(isset($fetch_liked)){
                        echo "<script>alert('좋아요는 1회만 클릭 가능합니다.');</script>";
                    } else {
                        //likes 엠데이트 해주기
                        $query_like = "UPDATE freeboard SET likes=likes+1 where num='$num'";
                        $result_like = mysqli_query($conn, $query_like);
                        
                        //like 디비 업데이트 해주기
                        $query_likelist = "
                            INSERT INTO freeboard_like
                            (userid, con_num, date)
                            VALUES(
                            '$uid',
                            $num,
                            NOW()
                            )";
                            $result_likelist = mysqli_query($conn, $query_likelist);
                    }

                    // 자료 다시 받아와서 출력
                    $result = mysqli_query($conn, $sqlNum); 
                    $data_like = mysqli_fetch_array($result);
                    echo $data_like['likes'];
                } else {
                    echo $data['likes'];
                }
            ?>
            <!-- 좋아요 클릭시 post 보내기 -->
            <form method="post">
                <p><input type="submit" name="like_btn" value=" " id="like_img" /></p>
            </form>
            </div>
            <!-- 글쓴이가 작성한 다른 글 -->
            <div style="float:center">
            <br>
            <p style="font-size:small; text-align:center">&nbsp<?=$data['name'];?>'s other article</p>
            
                <?php
                $uid_other=$data['uid'];
                $name_writer=$data['name'];
                $url_writer = "./other_article.php?name=".$name_writer;
                $sql_otherArticle = "SELECT * FROM freeboard where uid='$uid_other' LIMIT 4";
                $reply_otherArticle = mysqli_query($conn, $sql_otherArticle) or die("Error");
                $total_rows_otherArticle = mysqli_num_rows($reply_otherArticle);
                for($i=1; $i<$total_rows_otherArticle; $i++){
                    $fetch_other = mysqli_fetch_array($reply_otherArticle);
                    $title_other = $fetch_other['title'];
                    $num_other = $fetch_other['num'];
                    $url_other = "?num=".$num_other;
                ?>
                <li style="font-size: x-small"><a href=<?=$url_other?>><?=$title_other?></a></li>
                <?php
                }
                ?>
                <p style="font-size:small; text-align:center"><a href=<?=$url_writer?> >더보기</a></p>
            </div>
        </div>
      </div>
        <br>
        <!-- 버튼(목록, 삭제, 수정) -->
        <?php if($uidSession == $uid_other){?>
            <button type="button" class="btn btn-outline-primary" style="float:right" onclick="location.href='<?=$url?>'">수정</button>
            <form action="process-delete.php" method="post">
                <input type="hidden" name="num" value="<?=$num?>">
                <input type="submit" value="삭제" class="btn btn-outline-primary" style="float:right">
            </form>
        <?php } ?>

        <?php
        $page = $_GET['page'];
        $list_url = './free-board.php?page='.$page;
        ?>
        <button type="button" class="btn btn-outline-primary" style="float:right" onclick="location.href='<?=$list_url?>'">목록</button><br><br><br>

        <!-- 댓글 입력 창 -->                
        <?php
        if(isset($_SESSION['id'])){
        ?>
            <form action="comment_ok.php" id="form1" method="post">
                <input type="hidden" name="con_idx" value="<?=$num?>">
                <input type="text" name="content" id="editextReply" class="form-control" placeholder="댓글을 입력해주세요."/>
                <input type="submit" id="" class="btn btn-outline-primary form-control" onclick="create_reply(<?=$num?>); return false;"/>
            </form><br>
        <?php
        }
        ?>

        <!-- 댓글 목록(ajax버전) -->
        <table class="table">
            <tbody class="replies">
                
            </tbody>
        </table>
    </div><br>

<script>
    
function getFormatDate(date){
    var year = date.getFullYear();              //yyyy
    var month = (1 + date.getMonth());          //M
    month = month >= 10 ? month : '0' + month;  //month 두자리로 저장
    var day = date.getDate();                   //d
    day = day >= 10 ? day : '0' + day;          //day 두자리로 저장
    return  year + '' + month + '' + day;
}

function replyClicked(var_reply){
    var reply_form = document.getElementById(var_reply);

    if(reply_form.style.display=='none'){
        reply_form.style.display = 'block';
    }else{
        reply_form.style.display = 'none';
    }
}

var read_before;    //하나의 버튼으로 두가지 기능(보이기&숨기기)을 수행하기 위한 변수 아 근데 이게...
function replyReadClicked(read_reply){

    var reply_read = document.getElementsByClassName(read_reply)[0];
    console.log(reply_read);
    //console.log(reply_read[0]);

    if(reply_read.style.display=='block'){
        //지우기
        $("."+read_reply+" *").remove();
        reply_read.style.display='none';
    
    } else {
        getReplyList(read_reply);
        reply_read.style.display='block';
       
    }

    // var reply_write_form = document.getElementById(read_reply);
    
    // if(reply_write_form.style.display=='none'){
    //     reply_write_form.style.display = 'block';
    // }else{
    //     reply_write_form.style.display = 'none';
    // }
}

//대댓글
    $(document).ready(function(){
        getAllList(<?=$num?>);
    });

    //var str = "";

    function getAllList(num_board){
        var board_num = num_board;
        
        //$("#board_num").val(); // 아니 board_num이 어딨어? 뭐 이거는 mysql로 받아오면 되니까 일단 18번으로 가자

        console.log("getAllList()");
        console.log("board_num"+board_num);

        $.getJSON("comment_list.php?board_num="+board_num, function(data){
            console.log(data);
            $(".replies *").remove();
            $(data).each(function(){
                
                //작성자만 삭제 가능하도록
                if(this.name == '<?=$uName?>'){
                   var form_delete = '<td><form id="form2" action="process-delete-reply.php" method="post"><input type="hidden" name="idx" value="'+this.idx+'"><input type="submit" id="delete_img" value=" " onclick="delete_reply(<?=$num?>); return false;"></form></td>';
                }else{
                   var form_delete = ' ';
                }
                
                //대댓글 작성폼 보이기&숨기기 button
                if('<?=$uName?>' == ''){
                    var rereply_form = '';
                    
                }else{
                    var rereply_form = '<button type="button" class="btn btn-light btn-sm" onclick="replyClicked(\'form'+this.idx+'\')">답글</button>';
                }                

                //대댓글 작성폼
                var rereply_write = '<form action="process-re-reply.php" style="display:none" id="form'+this.idx+'" method="post"><br><input type="hidden" name="con_idx" value="'+this.idx+'"><input type="text" class="form-control" name="content" id=""/><input type="submit" class="btn btn-outline-primary form-control btn-sm" id="" onclick="create_rereply('+this.idx+'); return false;"/></form>'
                
                //대댓글 더보기 보이기&숨기기 button
                var rereply_read = '<button type="button" id="button'+this.idx+'" class="btn btn-link btn-sm" onclick="replyReadClicked('+this.idx+')" style="display:none">답글 보기</button>';

                //대댓글 list
                var rereply_list = '<div class="'+this.idx+'" style="display:none"></div>';

                $(".replies").append('<tr><td style="width:20%">'+this.name+'</td><td>'+this.content+'&ensp;'+rereply_form+rereply_write+'<br>'+rereply_read+rereply_list+'</td><td style="width:20%">'+this.created+'</td style="width:10%">'+form_delete+'</tr>');
                
                //대댓글이 있을 경우에만 대댓글 더보기 버튼 활성화
                getReplyNum(this.idx);
               
            });
            
        });

    }

    //답글 더보기 css 제어(php에서 길이 확인 후)
    var getReplyNum = function(idx){
        
        var idx_checklength = idx;

        $.ajax({
            type: 'GET',
            url : 'get_length.php?idx='+idx_checklength,
            success : function(response){
                if(response=='success'){
                    $("#button"+idx_checklength).css("display", "block");
                }
            }
        });
    }

    function getReplyList(idx_num){
        
        //$("#board_num").val(); // 아니 board_num이 어딨어? 뭐 이거는 mysql로 받아오면 되니까 일단 18번으로 가자

        console.log("getReplyList()");
        
    
        $.getJSON("rereply_list.php?idx_num="+idx_num, function(data){
            console.log(data);
            $("."+idx_num+" *").remove();
            $(data).each(function(){
                
                
                if(this.name == '<?=$uName?>'){
                   var re_delete = '<form id="del"'+this.idx+' style="display:inline" action="process-delete-re-reply.php" method="post"><input type="hidden" name="idx" value="'+this.idx+'"><input type="submit" id="delete_img" value=" " onclick="delete_rereply(<?=$num?>); return false;"></form>';
                }else{
                   var re_delete = ' ';
                }
            
                $("."+idx_num).append('<div style="line-height:110%; border-bottom:1px solid grey; padding:5px"><font size="1">'+this.name+'&nbsp/&nbsp'+this.created+'</font><br>&ensp;<font size="2">'+this.content+'</font>&ensp;'+re_delete+'<br><div>');
                
            });    
        });
    }


    function create_reply(num_board){
        var formData = $("#form1").serialize();
        $.ajax({
            type: 'POST',
            url : 'comment_ok.php',
            data : formData,
            success : function(response){
                if(response=='success'){
                    //alert("success");
                    getAllList(num_board);
                   
                }
            }
        });
        
    }

    function create_rereply(num_board){
        var form_name = '#form'+num_board;
        console.log(form_name);
        var formData3 = $(form_name).serialize();
        $.ajax({
            type: 'POST',
            url : 'process-re-reply.php',
            data : formData3,
            success : function(response){
                if(response=='success'){
                    //alert("success");
                    getReplyList(num_board);
                }
            }
        });
    }

    function delete_reply(num_board){
        var formData2 = $("#form2").serialize();
        $.ajax({
            type: 'POST',
            url : 'process-delete-reply.php',
            data : formData2,
            success : function(response){
                if(response=='success'){
                    alert("success");
                    getAllList(num_board);
                }
            }
        });
    }

    function delete_rereply(num_board){
        var form_name4 = '#del'+num_board;
        console.log(form_name);
        var formData4 = $(form_name4).serialize();
        $.ajax({
            type: 'POST',
            url : 'process-delete-re-reply.php',
            data : formData2,
            success : function(response){
                if(response=='success'){
                    alert("success");
                    //getAllList(num_board);
                }
            }
        });
    }

</script>

 <!-- Bootstrap core JavaScript -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>