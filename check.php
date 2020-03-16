<?php
	$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
	$uid = $_GET["userid"];
    $sql = "SELECT * from user where email='".$uid."'";
    $result = mysqli_query($conn, $sql);
    $member = mysqli_fetch_array($result);
	if($member==0)
	{
    setcookie("idcheck", "$uid", time()+60*60);
?>
	<div style='font-family:"malgun gothic"';><?php echo $uid; ?>는 사용가능한 아이디입니다.</div>
<?php 
	}else{
?>
	<div style='font-family:"malgun gothic"; color:red;'><?php echo $uid; ?>중복된아이디입니다.<div>
<?php
	}
?>
<button value="닫기" onclick="window.close()" style="align: right;">닫기</button>
<script>
</script>