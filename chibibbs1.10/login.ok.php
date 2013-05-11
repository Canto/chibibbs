<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
/* DB정보취득 */
include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
/* 게시판 기본 함수 로드*/
include_once "lib/bbs.fn.php";
/* POST변수 재설정 */
if(empty($_POST)==false){
$user_id = $_POST['user_id'];
$passwd = $_POST['passwd'];
$mode = $_POST['mode'];
$cid = $_POST['cid'];
}
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'login.php')){ /* 접속경로 체크 */
/* 멤버 정보 취득 */
$member = member($user_id,$chibi_conn);
if(empty($member->user_id)==true){
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
</style>
</head>
<body>
<div class="container">
<div class="row-fluid">
<div class="span6 offset3">
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
존재하지 않는 멤버입니다.<br/>계정 혹은 비밀번호를 확인해주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
</div>
</div>
</body>
</html>
<?php
}else if(md5($passwd)==$member->passwd && login_ok($user_id,$chibi_conn)==true){/* 패스워드 체크 */
		if($mode == "admin"){/* 관리자 페이지로 이동 */
			echo "<script type=\"text/javascript\">
			alert(\"로그인이 완료되었습니다.\");
			location.href=\"admin/admin.php\";
			</script>";
		}
		if(empty($cid)==false){
			echo "<script type=\"text/javascript\">
			alert(\"로그인이 완료되었습니다.\");
			location.href=\"index.php?cid=".$cid."\";
			</script>";
		}
}else{
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
</style>
</head>
<body>
<div class="container">
<div class="row-fluid">
<div class="span6 offset3">
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
비밀번호가 틀렸습니다.<br/>계정 혹은 비밀번호를 확인해주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
</div>
</div>
</body>
</html>
<?php
}
}else{
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 로그인</title>
<style type="text/css">
body{margin:20px;background:#e8e8e8;}
</style>
</head>
<body>
<div class="container">
<div class="row-fluid">
<div class="span6 offset3">
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
올바른 접속경로를 통해 접속하여 주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
</div>
</div>
</body>
</html>
<?php
}
?>