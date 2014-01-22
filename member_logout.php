<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
$cid = $_POST['cid'];
$passwd = $_POST['passwd'];
if($cid){
	if(empty($_SESSION['session_key_cookie'])==false){
		$_SESSION['session_key_cookie']='';
		echo true;
	}else{
		echo false;
	}
}
?>