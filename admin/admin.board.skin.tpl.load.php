<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_POST['cid'];
$skin = $_POST['skin'];

include_once "../lib/bbs.fn.php";


$reset_tpl=fopen("../skin/".$skin."/layout.php","r");
$reset_tpl_file = '';
while (!feof($reset_tpl)){
	$reset_tpl_file = $reset_tpl_file.fgets($reset_tpl);
}
fclose($reset_tpl);
//$reset_tpl_file = htmlspecialchars($reset_tpl_file);

echo $reset_tpl_file;
?>