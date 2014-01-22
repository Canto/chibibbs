<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
$passwd = $_POST['passwd'];
/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";
include_once "../lib/bbs.fn.php";
if($cid){
	$bbs_query = select($cid,$chibi_conn);
	$bbs = (object) mysql_fetch_array($bbs_query);
	$bbs->spam = (object) unserialize($bbs->spam);
	$bbs->notice = (object) unserialize($bbs->notice);
	$bbs->op = (object) unserialize($bbs->op);

	if(md5($passwd) == $bbs->passwd){
		$time = time();
		$_SESSION['session_key_cookie']=md5($cid.'+'.session_id());
//		setcookie('session_key_cookie',$cid.'+'.session_id(),0,'/');
		echo true;
	}else{
		echo false;
	}
mysql_close($chibi_conn);
}
?>