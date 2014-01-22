<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_POST['cid'];
$idx = $_POST['idx'];
if(empty($_POST['op'])==false){
	$op = $_POST['op'];
	$op = serialize($op);
}
else{
	$op = '';
}
/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

$query = "UPDATE `chibi_pic` SET `op`='".mysql_real_escape_string($op)."' WHERE `idx`='".mysql_real_escape_string($idx)."' AND `cid`='".mysql_real_escape_string($cid)."'";

if(mysql_query($query,$chibi_conn)){
		$chk = true;
		echo $chk;
}else{
	$chk = false;
	echo $chk;
}
mysql_close($chibi_conn);
?>