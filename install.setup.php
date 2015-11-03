<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
if(is_file("data/config/db.config.php")==true){
	include_once 'data/config/db.config.php';
	include_once "lib/db.conn.php";
	if(is_resource(mysqli_query($chibi_conn, "DESC chibi_admin")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_skin")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_pic")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_comment")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_tpl")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_member")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_emoticon")) && is_resource(mysqli_query($chibi_conn, "DESC chibi_log")))
	{
		echo "
	<script language=\"javascript\">
	alert('CHIBIBBS 가 이미 설치되어 있습니다.');
	</script>
	";
		exit;
	}
}
$_SESSION['rndkey'] = time();
$_SESSION['setup'] = $_SESSION['rndkey'].'adminsetup';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 1.10 설치</title>
<style>
body{background:#e8e8e8;font-size:12px;margin:20px;font-family:돋움,dotum;}
#license{width:500px;height:150px;font-size:12px;}
#setupDiv{width:550px;height:100%;margin:0 auto;}
.control-label, input{font-size:12px !important;}
.controls{text-align:left;}
</style>
</head>
<body>
<div align="center" id="setupDiv">
<form method="post" id="install" action="install.check.php" class="form-horizontal">
<div class="control-group">
<input type="hidden" name="mode" value="install">
<input type="hidden" name="type" value="install">
<textarea readonly id="license">
** 주의사항 **
1. 본 게시판은 오픈소스 라이센스 규약인 GPLv3 에 의거하여 배포됩니다. 
2. 스킨 제작자 분들은 따로 연락을 주시면 스킨제작에 있어 
   최대한 서포트 해 드리겠습니다.
3. 게시판 및 ChibiPAINT프로그램에 관련된 오류나 버그는 제작자 개인홈이나
   배포페이지를 이용해주세요.
4. 본 게시판을 이용하기 위해서는 JAVA 가 필요합니다.
   JAVA를 설치하지 않은 분은 
   http://www.java.com/ko/download/ie_manual.jsp?locale=ko&host=www.java.com
   에서 다운로드를 해 주시기 바랍니다.
</textarea>
<?php 
if(!is_writable('./data')){
?>
<p class="text-error">data 폴더의 권한이 <b>707</b> 혹은 <b>777</b>이 아닙니다<br/>data 폴더의 권한을 확인해주세요.</p>
<? }else{ ?>
</div>

<div class="control-group">
	<label class="control-label" for="host">호스트명</label>
	<div class="controls">
		<input type="text" id="host" name="host" placeholder="호스트명" required value="localhost">
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="dbname">DB 이름</label>
	<div class="controls">
		<input type="text" id="dbname" name="dbname" placeholder="DB 이름" required>
		<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 이름을 입력하세요.</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="dbuser">DB 아이디</label>
	<div class="controls">
		<input type="text" id="dbuser" name="dbuser" placeholder="DB 아이디" required>
		<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 아이디를 입력하세요.</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="dbpass">DB 패스워드</label>
	<div class="controls">
		<input type="password" id="dbpass" name="dbpass" placeholder="DB 패스워드" required>
		<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 패스워드를 입력하세요.</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="admin_id">최고관리자 아이디</label>
	<div class="controls">
		<input type="text" id="admin_id" name="admin_id" placeholder="최고관리자 아이디" onblur="checkID()"  required>
		<span class="help-block">치비BBS 전체를 관리 할 수 있는 관리자 아이디를 입력하세요.</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="admin_pass">최고관리자 패스워드</label>
	<div class="controls">
		<input type="password" id="admin_pass" name="admin_pass" placeholder="최고관리자 패스워드" onblur="checkPASSWD()" required>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="nickname">최고관리자 닉네임</label>
	<div class="controls">
		<input type="text" id="nickname" name="nickname" placeholder="최고관리자 닉네임" required>
	</div>
</div>
<div class="control-group">
	<button type="submin" class="btn btn-primary">설치</button>
</div>
</form>
<script type="text/javascript">
function checkID(){
	var pattern = /^[a-z]+[a-z0-9]*$/; 
		 if($("#admin_id").val() == ""){
		  alert("최고관리자 ID를 입력해 주세요.");
		  $("#admin_id").focus();
	 }else if(!pattern.test($("#admin_id").val())){
		 alert("최고관리자 ID는 영문 소문자 혹은 영문(소문자)+숫자로만 입력가능합니다.");
		 $("#admin_id").focus();
	 }
	}
function checkPASSWD(){
		 if($("#admin_pass").val() == ""){
		  alert("최고관리자 패스워드를 입력해 주세요.");
		  $("#admin_pass").focus();
	 }
	}
</script>
</div>
</body>
</html>
<?php
}
?>