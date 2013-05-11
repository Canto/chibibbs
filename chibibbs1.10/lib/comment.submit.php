<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}

if(empty($_POST['depth'])==false){
	$depth = $_POST['depth'];
	$depth++;
}
else{
	$depth = 1;
}
if(empty($_POST['no'])==false){
$no = $_POST['no'];
if($depth==1)$no++;
}else{
$no = 1;
}
$pic_no = $_POST['pic_no'];
if(empty($_POST['op'])==false){
	$op = $_POST['op'];
	if($op['dice']) $op['dice'] = rand(1,6)."+".rand(1,6);
	$op = serialize($op);
}
else{
	$op = '';
}


$hpurl ='';


/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";
$bbs_query = select($cid,$chibi_conn);
$bbs = mysql_fetch_array($bbs_query);
$spamword = unserialize($bbs['spam']);
//echo $spam['word'];
if($name && $passwd && $comment && $no && $pic_no){
$cf_filter = explode(",", $spamword['word']); 
foreach ($cf_filter as $filter) { 
    $filter = trim($filter); 
    if (strstr($comment, $filter)) 
        $spam = $filter;
}
if(empty($spam)==false){
	echo $spam;

}else{

	  $query = "INSERT INTO `chibi_comment` (`idx`,`cid`,`pic_no`,`no`, `depth`, `name`, `passwd`, `rtime`, `comment`, `memo`, `hpurl`, `ip`, `op`)VALUES('','".mysql_real_escape_string($cid)."','".mysql_real_escape_string($pic_no)."','".mysql_real_escape_string($no)."','".mysql_real_escape_string($depth)."','".mysql_real_escape_string($name)."','".mysql_real_escape_string(md5($passwd))."','".time()."','".mysql_real_escape_string($comment)."','','".mysql_real_escape_string($hpurl)."','".$_SERVER["REMOTE_ADDR"]."','".mysql_real_escape_string($op)."')";
	  mysql_query($query,$chibi_conn);	  
		$chk = true;
		echo $chk;
}
}else{
	$chk = false;
	echo $chk;
}

mysql_close($chibi_conn);
?>