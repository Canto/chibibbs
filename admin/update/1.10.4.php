<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
/* DB정보취득 */
include_once "../../data/config/db.config.php";
include_once "../../lib/db.conn.php";
$sql = "ALTER TABLE `chibi_comment` ADD `children` INT(10) NOT NULL AFTER `no`, ADD INDEX (children)";
mysqli_query($chibi_conn, $sql);
$error = mysqli_error($chibi_conn);
if($error){ 
	$chk = false;
	echo $chk; 
}else{ 
	$chk = true;
	echo $chk; 
}
mysqli_close($chibi_conn);
?>