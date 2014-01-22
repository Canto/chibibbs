<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());

if(is_file("data/config/db.config.php")==false){ /* 1차 설치 확인 */
	echo "<script type=\"text/javascript\">location.href=\"../install.setup.php\";</script>";
}

/* DB정보취득 */
include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
/* 게시판 기본 함수 로드*/
include_once "lib/bbs.fn.php";

/* 2차 설치 확인 */
if(setup_check($chibi_conn)==false){
	echo "<script type=\"text/javascript\">location.href=\"../install.setup.php\";</script>";
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 로그인</title>
<style type="text/css">
body{margin:20px;background:#e8e8e8;}
.main{margin:0 auto !important;}
.control-label, input{font-size:12px !important;}
.controls{text-align:left;}
td{background:#ffffff;}
</style>
</head>
<body>
<div class="container">
<div class="row-fluid">
<div class="span12 main">
<?php
/* 로그인 체크 */
if(login_check($chibi_conn)==true){/* 이미 로그인 상태일 경우 */
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
이미 로그인을 하신 상태입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>

</div>
<?php
}else{
?>
<div class="span6 offset3">
<form class="form-horizontal" method="post" action="login.ok.php">
<table class="table table-bordered">
<tbody>
<tr class="info">
<td>
Member 로그인
</td>
</tr>
<tr>
<td>
<div class="control-group">
	<label class="control-label" for="user_id">아이디</label>
	<div class="controls">
		<input type="text" id="user_id" name="user_id" placeholder="아이디" required>
	</div>
</div>
</td>
<tr>
<td>
<div class="control-group">
	<label class="control-label" for="passwd">패스워드</label>
	<div class="controls">
		<input type="password" id="passwd" name="passwd" placeholder="패스워드" required>
	</div>
</div>
</td>
</tr>
<tr class="info">
<td>
	<input type="hidden" name="mode" value="<?php if(empty($_GET['mode'])==false) echo $_GET['mode']; ?>">
	<input type="hidden" name="cid" value="<?php if(empty($_GET['cid'])==false) echo $_GET['cid']; ?>">
	<div class="control-group">
		<div class="controls from-actions">
			<button type="submit" class="btn btn-primary">로그인</button>
			<a class="btn" href="javascript:history.go(-1);">돌아가기</a>
		</div>
	</div>
</td>
</tr>
</tbody>
</table>
</form>
</div>
<?php
}
?>
</div>
</div>
</body>
</html>
