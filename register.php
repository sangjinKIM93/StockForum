<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Heroic Features - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/heroic-features.css" rel="stylesheet">

  <style media="screen">
    #register{
      margin: auto;
      width: 50%;
      padding: 10px;
      text-align: center;
    }
    /* .help-block 을 일단 보이지 않게 설정 */
    #myForm .help-block{
        display: none;
    }
    /* glyphicon 을 일단 보이지 않게 설정 */
    #myForm .glyphicon{
        display: none;
    }
  </style>

</head>
<body>
  <!-- Navigation -->
  <?php include 'menubar.php'; ?>

  <div class="container">
    <h3>회원가입</h3>
    <form action="process-register.php" method="post" id="myForm" onsubmit="return checkcookie()">
        
        <div class="form-group has-feedback">
            <label class="control-label" for="email">이메일</label>
            <input class="form-control" type="text" name="email" id="email"/>
            <span id="emailErr" class="help-block" style="color:DarkOrange;">올바른 이메일 형식이 아닙니다. 다시 입력해 주세요.</span>
            <input type="button" class="btn btn-primary" value="중복검사" style="float:right" onclick="checkid();"/><br>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label" for="pwd">비밀번호</label>
            <input class="form-control" type="password" name="pwd" id="pwd"/>
            <span id="pwdRegErr" class="help-block" style="color:DarkOrange;">8글자 이상 입력하세요.</span>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label" for="rePwd">비밀번호 재확인</label>
            <input class="form-control" type="password" name="rePwd" id="rePwd"/>
            <span id="rePwdErr" class="help-block" style="color:DarkOrange;">비밀번호와 일치하지 않습니다. 다시 입력해 주세요.</span>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label" for="id">이름</label>
            <input class="form-control" type="text" name="name" id="uid"/>
            
            <span id="overlapErr" class="help-block">사용할 수 없는 아이디 입니다.</span>
        </div>
        
        <button class="btn btn-success" type="submit" disabled="true">가입</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    //아이디 입력란에 keyup 이벤트가 일어 났을때 실행할 함수 등록 
    // $("#id").keyup(function(){
    //     //입력한 문자열을 읽어온다.
    //     var id=$(this).val();
    //     //ajax 요청을 해서 서버에 전송한다.
    //     $.ajax({
    //         method:"post",
    //         url:"id_check.php",
    //         data:{id_check:id_check},
    //         success:function(data){
    //             var obj=JSON.parse(data);
    //             if(obj.canUse){//사용 가능한 아이디 라면 
    //                 $("#overlapErr").hide();
    //                 // 성공한 상태로 바꾸는 함수 호출
    //                 successState("#id");
                    
    //             }else{//사용 가능한 아이디가 아니라면 
    //                 $("#overlapErr").show();
    //                 errorState("#id");
    //             }
    //         }
    //     });
    // });

    var getCookie = function(name) {
        var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return value? value[2] : null;
    };


    function checkcookie(){
      var userid_ck = document.getElementById("email").value;
      var target_cookie = getCookie("idcheck");
      if(!target_cookie){
        alert('아이디 중복을 확인하세요');
        return false;
      }
      var filtered_cookie = target_cookie.replace('%40', '@');
      if(filtered_cookie == userid_ck && userid_ck != ' '){
        return true;
      }else{
        alert('아이디 중복을 확인하세요');
        return false;
      }
      
    }

    function checkid(){
      var userid = document.getElementById("email").value;
      if(userid){
        url = "check.php?userid="+userid;
			  window.open(url,"chkid","width=300,height=100");
      }else{
        alert("아이디를 입력하세요");
      }
    }

    $("#pwd").keyup(function(){     //pwd가 입력되는지 인식하는 리스너
        var pwd=$(this).val();      //.val()은 양식의 갑을 가져옴. *반대로 설정할 수도 있음
        // 비밀번호 검증할 정규 표현식
        var reg=/^.{8,}$/;
        if(reg.test(pwd)){//정규표현식을 통과 한다면
                    $("#pwdRegErr").hide();
                    successState("#pwd");
        }else{//정규표현식을 통과하지 못하면
                    $("#pwdRegErr").show();
                    errorState("#pwd");
        }
    });
    $("#rePwd").keyup(function(){
        var rePwd=$(this).val();
        var pwd=$("#pwd").val();
        // 비밀번호 같은지 확인
        if(rePwd==pwd){//비밀번호 같다면
            $("#rePwdErr").hide();
            successState("#rePwd");
        }else{//비밀번호 다르다면
            $("#rePwdErr").show();
            errorState("#rePwd");
        }
    });
    $("#email").keyup(function(){
        var email=$(this).val();
        // 이메일 검증할 정규 표현식
        var reg=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(reg.test(email)){//정규표현식을 통과 한다면
                    $("#emailErr").hide();
                    successState("#email");
        }else{//정규표현식을 통과하지 못하면
                    $("#emailErr").show();
                    errorState("#email");
        }
    });
    // 성공 상태로 바꾸는 함수
    function successState(sel){
        $("#myForm button[type=submit]")
                    .removeAttr("disabled");   
    };
    // 에러 상태로 바꾸는 함수
    function errorState(sel){
        $("#myForm button[type=submit]")
                    .attr("disabled","disabled");    //버튼 클릭 안 되도록
    };
</script>    


  <!-- register form -->
  <!-- <br><br><br><br>
    <div id="register">
    <h1>Registration</h1>
    <form action="process-register.php" method="post">
      <div class="form-group">
        <input type="email" class="form-control" aria-describedby="emailHelp" name="uid" placeholder="id">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" id="pw1" name="password1" placeholder="password" onkeyup='check();' />
      </div>
      <div class="form-group">
        <input type="password" class="form-control" id="pw1" name="password1" placeholder="password-check" onkeyup='check();' />
      </div>
      <div class="form-group">
        <input type="text"  class="form-control" name="name" placeholder="name" />
      </div>
      <p><input type="submit" value="register"></p>
    </form>
  </div> -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
