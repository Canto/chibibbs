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

$query = "UPDATE `chibi_pic` SET `op`='".mysqli_real_escape_string($chibi_conn, $op)."' WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."' AND `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";

if(mysqli_query($chibi_conn, $query)){
		$chk = true;
		echo $chk;
}else{
	$chk = false;
	echo $chk;
}
mysqli_close($chibi_conn);
?>