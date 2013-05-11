<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$url = $_GET['url'];
$cid = $_GET['cid'];
$inst = $_GET['inst'];
/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";
include_once "../lib/bbs.fn.php";
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminEmoticonSetup')){ 
if(empty($url)==false) {
      rmemoticon($url);
	  $query = "DELETE FROM `chibi_emoticon` WHERE `cid`='".mysql_real_escape_string($cid)."' AND `inst`='".mysql_real_escape_string($inst)."'";
	  mysql_query($query,$chibi_conn);	  
	$chk = "true";
	echo $chk;
}else{
	$chk = "false";
	echo $chk;
}
mysql_close($chibi_conn);
}else{

}
?>