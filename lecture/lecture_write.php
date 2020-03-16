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
    <!-- datepicker -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <!-- ckeditor -->
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <!-- naver map -->
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=wp2ind2rrp"></script>
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

        <form name="writeForm" action="process-lecture.php" method="POST" enctype="multipart/form-data" onsubmit="return essential()">
            <h6>*필수 항목</h6>
            <div style="border: 1px solid lightgrey; padding: 10px; border-radius: 7px">
                <!-- 이미지 업로드 -->
                <div class="form-inline">
                    썸 네일:&nbsp;
                    <div class="form-group col-1">
                        <img src="file_uploads/placeholder.jpg" onclick="triggerClick()" id="profileDisplay"/>
                    </div>
                    <!-- <label for="fileUpLoad">Main Image</label> -->
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="displayImage(this)" style="display:none">
                </div><br>    
            
                <!-- datepicker 폼 -->
                <div class="form-inline">
                    <label for="datepicker" class="form-group">강연 날짜:</label>
                    <div class="form-group col-1">
                        <input type="text" class="form-control" id="datepicker" name="lectureDay" placeholder="click here!"/>
                    </div>
                </div><br>
                <!-- timepicker -->
                <div class="form-inline">
                    <label for="address" class="form-group">강연 시간:</label>&ensp;&ensp;
                    <div class="form-group">
                        <input type="text" class="form-control timepicker"  name="startTime" placeholder="click here!"/>
                    </div>
                    &ensp;&ensp;~&ensp;&ensp;
                    <div class="form-group">
                        <input type="text" class="form-control timepicker"  name="endTime" placeholder="click here!"/>
                    </div>
                </div><br>  

                <!-- 장소 등록 -->
                <div class="form-inline">
                    <label for="address" class="form-group">강연 장소:</label>&ensp;&ensp;
                    <div class="form-group">
                        <input type="text" id="address" name="address" class="form-control" placeholder="주소">
                    </div>&ensp;
                    <div class="form-group">
                        <input type="button" class="form-control btn btn-primary" onclick="sample5_execDaumPostcode()" value="주소 검색">
                    </div>
                    
                </div>
                
                    <div class="form-inline" style="margin-left:83px">
                        <input type="text" name="addressDetail" class="form-control" placeholder="세부주소">
                    </div>&ensp;

                <!-- 가격 및 정원 -->
                <div class="form-inline">
                    <label for="address" class="form-group">가격(단위:원):</label>&ensp;&ensp;
                    <div class="form-group">
                        <input type="text" class="form-control"  name="price" placeholder="직접 입력"/>
                    </div>
                    &ensp;&ensp;&ensp;&ensp;<label for="address" class="form-group">최대 인원:</label>&ensp;&ensp;
                    <div class="form-group">
                        <input type="text" class="form-control"  name="limitation" placeholder="직접 입력"/>
                    </div>
                </div><br>   
            </div><br>

            <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요."><br>
            <!-- ckeditor -->
            <textarea name="content" id="editor"></textarea>
            <script>
                CKEDITOR.replace('editor', {
                    height:300,
                    filebrowserUploadUrl:'upload.php'
                });
            </script><br>  

            
            
            <!-- 접수 마감 -->
            <div class="form-check" style="float:left">
                <input type="checkbox" class="form-check-input" name="finished" id="finished">
                <label for="finished" class="form-check-label">모집 완료시 check(모집 인원 충족시 자동 체크됨).</label>
            </div>

            <p><input type="submit" class="btn btn-primary" name="save-user" value="완료" style="float: right"></p><br>
        </form>
    </div><br>

    <script>
        //datepicker 설정
        $("#datepicker").datepicker();
        //timepicker
        $('.timepicker').timepicker();
        
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

        //필수 항목
        function essential(){
            console.log("essential()");
            if(document.writeForm.datepicker.value == ""){
                alert('날짜를 선택해주세요.');
                return false;
            }
            if(document.writeForm.startTime.value == ""){
                alert('시작시간을 선택해주세요.');
                console.log("시작시간을() if문 내부");
                return false;
            } 
            if(document.writeForm.endTime.value == ""){
                alert('종료시간을 선택해주세요.');
                return false;
            }
            if(document.writeForm.address.value == ""){
                alert('주소를 선택해주세요.');
                return false;
            } 
            if(document.writeForm.addressDetail.value == ""){
                alert('세부주소를 입력해주세요.');
                return false;
            } 
            if(document.writeForm.price.value == ""){
                alert('가격을 입력해주세요.');
                return false;
            } 
            if(document.writeForm.limitation.value == ""){
                alert('최대인원을 입력해주세요.');
                return false;
            } 
            if(document.writeForm.title.value == ""){
                alert('제목을 입력해주세요.');
                return false;
            } 
            return true;
        }
    </script>

    <!-- 주소 입력창 -->
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        function sample5_execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function(data) {
                    var addr = data.address; // 최종 주소 변수

                    // 주소 정보를 해당 필드에 넣는다.
                    document.getElementById("address").value = addr;
                    
                }
            }).open();
        }
    </script>


     <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>