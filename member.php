<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());

if(is_file("data/config/db.config.php")==false){
	echo "<script type=\"text/javascript\">location.href=\"install.setup.php\";</script>";
}
/* GET to DB Info */
include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
/* Load Default Function Of BBS */
include_once "lib/bbs.fn.php";
include_once "lib/bbs.page.php";
/* Check Setup */
if(setup_check($chibi_conn)==false){
	echo "<script type=\"text/javascript\">location.href=\"install.setup.php\";</script>";
}

/* Reset Member Act */
if(empty($_GET['cAct'])==false){
	$cAct = $_GET['cAct'];
}
?>

<?php
login_check($chibi_conn);
switch($cAct){ /* Setup Member Act */
	
	case "memberJoin" : 
		include "member/member.join.php";
		break;
	case "memberJoinOk" :
		include "member/member.join.ok.php";
		break;
	case "memberModify" :
		include "member/member.modify.php";
		break;
	case "memberModifyOk" :
		include "member/member.modify.ok.php";
		break;
	default :
		echo '
		<!DOCTYPE html>
		<html lang="ko">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
			<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
			<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
			<title> Chibi Tool BBS ver'.$chibi_ver.' 멤버 가입</title>
			<style type="text/css">
				body{margin:0px;background:#fcfcfc;}
				.count{background:#d9edf7;}
				.content{background:#ffffff;}
				.logo{color:#ffffff !important;}
				.margin70{margin-top:50px;}
				.margin20{margin-top:20px;}
				th{font-size:12px;}
				td{font-size:12px;}
				.messageDiv{display:none !important;top:30%;position:fixed;}
				#board-create input,#board-create select,#board-create textarea{font-size:12px;}
				#board-create .td-left{background:#eeeeee;font-size:12px;}
				#board-create .td-right{background:#ffffff;font-size:12px;}
			</style>
		</head>
		<body>
		<div class="span6 offset3 alert alert-error" style="margin-top: 10px;">
					올바른 경로로 접속하여 주세요.<br/>
		</div>
		</body>
		</html>
		';
		break;
}
?>