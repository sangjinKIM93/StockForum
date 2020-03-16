<?php
    $conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
    $idx = $_GET[idx];
    $sqlNum = "SELECT * FROM lectureboard Where idx = '$idx'";  //이게 수행되었을까?
    $result = mysqli_query($conn, $sqlNum);  //이게 작동했을까?
    $data = mysqli_fetch_array($result)
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
    <!-- jquery for DatePicker -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- ckeditor -->
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    <style>
    #profileDisplay{
        display: block;
        width: 150px;
        height: 200px;
        border-radius: 10px;
    }
    </style>
    
</head>
<body>
<!-- navigation -->
<?php include 'menubar_lecture.php'; ?>

    <div class="container">
        <h5>퀀트/주식 강연(강의 등록)</h5><br><br>

        <form action="edit_lecture.php" method="POST" enctype="multipart/form-data">
            <!-- datepicker 폼 -->
            <input type="hidden" name="idx" value='<?=$idx?>'>
            <input type="hidden" name="imageFile" value='<?=$data['imageFile']?>'>
            <div class="form-inline">
                <label for="datepicker" class="form-group">강연 날짜:&nbsp;</label>
                <div class="form-group col-2">
                    <input type="text" class="form-control" id="datepicker" name="lectureDay" value="<?=$data['lectureDay']?>"/>
                </div>
            </div><br>
            <!-- 이미지 업로드 -->
            <div class="form-inline">
                썸 네일:&nbsp;
                <div class="form-group col-1">
                    <img src="file_uploads/<?=$data['imageFile']?>" onclick="triggerClick()" id="profileDisplay"/>
                </div>
                <!-- <label for="fileUpLoad">Main Image</label> -->
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="displayImage(this)" style="display:none">
            </div><br>
            
            <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요." value="<?=$data['title']?>"><br>
            <!-- ckeditor -->
            <textarea name="content" id="editor"><?=$data['content']?></textarea>
            <script>
                CKEDITOR.replace('editor', {
                    height:300,
                    filebrowserUploadUrl:'upload.php'
                });
            </script><br>  
            
            <!-- 접수 마감 -->
            <div class="form-check" style="float:left">
                <?php if($data['finished'] == 'on'){ ?>  
                  <input type="checkbox" class="form-check-input" name="finished" id="finished" checked="checked">
                <?php }else{ ?>
                  <input type="checkbox" class="form-check-input" name="finished" id="finished" >
                <?php } ?>
                
                <label for="finished" class="form-check-label">모집 완료시 check 해주세요.</label>
            </div>
            <p><input type="submit" class="btn btn-primary" name="save-user" value="완료" style="float: right"></p><br>
        </form>
    </div><br>

    <script>
        //datepicker 설정
        $("#datepicker").datepicker();

        //이미지 클릭으로 filetoupload 클릭 대체
        function triggerClick(){
            document.querySelector('#fileToUpload').click();
        }
    
        //이미지 선택시 현재 이미지 바꾸기
        function displayImage(e){
            if(e.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>

     <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>