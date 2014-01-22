<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());

include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
include_once "lib/bbs.fn.php";

/* $_GET 변수 재설정 */
if(empty($_GET["user_id"])==false) $user_id = $_GET["user_id"];

$login_check = login_check($chibi_conn);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 로그아웃</title>
<style type="text/css">
body{margin:20px;background:#e8e8e8;}
td{background:#ffffff;}
</style>
</head>
<body>
<div class="container">
<div class="row-fluid">
<div class="span6 offset3">
<?php
	if(empty($user_id)==true){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
올바른 접속경로를 통해 접속하여 주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else{
	if(login_check($chibi_conn) == false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
로그인 상태가 아닙니다.<br/>
먼저 로그인을 하여주시기 바랍니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else{
	if(logout($user_id,$chibi_conn)){
	echo "<script type=\"text/javascript\">
			alert(\"로그아웃이 완료되었습니다.\");
			location.href = \"".$_SERVER['HTTP_REFERER']."\";
		</script>";
	}else{
	echo "<script type=\"text/javascript\">
			alert(\"로그아웃이 실패하였습니다..\");
			location.href = \"".$_SERVER['HTTP_REFERER']."\";
		</script>";
	}
}
}
?>
</div>
</div>
</body>
</html>