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

switch($cAct){ /* Setup Member Act */
	
	case "memberJoin" : 
		include "member/join.php";
		break;
	case "memberModify" :
		include "member/modify.php";
		break;
	default :
		echo "<div class=\"span6 offset3 alert alert-error\">
					올바른 경로로 접속하여 주세요.<br/>
				</div>";
		break;
}
?>