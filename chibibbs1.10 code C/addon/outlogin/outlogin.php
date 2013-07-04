<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
/* DB정보취득 */
include_once "../../data/config/db.config.php";
include_once "../../lib/db.conn.php";
$login_skin = $_GET['outlogin_skin'];
function outlogin($skin,$session){
	include_once 'skin/'.$skin.'/login.html';
}
include_once "skin/".$login_skin."/login.html";
?>
