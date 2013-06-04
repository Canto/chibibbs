<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$type = $_POST['type'];
$cid = $_POST['cid'];
$passwd = $_POST['passwd'];
if(empty($type)==false){
if($type=="picture"){

	$file=$_FILES['image']['name'];
	$t =microtime();
	$fn = explode(' ',$t);
	$av = ($fn[1]+$fn[0])*100000000;
	$filename = number_format($av,"0","","");
	$path = '../data/'.$cid."/";
	$ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));
	if ($ext == ".jpeg" || $ext == ".JPEG" || $ext == ".jpg" || $ext == ".JPG" || $ext == ".gif" || $ext == ".GIF" || $ext == ".PNG" || $ext == ".png") {
		move_uploaded_file($_FILES["image"]["tmp_name"], $path.$filename.$ext);
		$image = 'data/'.$cid.'/'.$filename.$ext;
	}else{
		$chk = false;
		return $chk;
		exit;
	}
}else{
	$image = $_POST['image'];
}
/* DBÁ¤º¸Ãëµæ */
include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";
$count_sql = "SELECT * FROM `chibi_pic` WHERE `cid`='".mysql_real_escape_string($cid)."' ORDER BY `idx` DESC";
$count_query = mysql_query($count_sql,$chibi_conn);
$count = mysql_fetch_array($count_query);
$query = "INSERT INTO `chibi_pic` (`idx`,`no`,`cid`, `type`, `src`, `passwd`, `agent`, `pic_ip`, `time`, `op`)VALUES('','".mysql_real_escape_string($count['no']+1)."','".mysql_real_escape_string($cid)."','".mysql_real_escape_string($type)."','".mysql_real_escape_string($image)."','".mysql_real_escape_string(md5($passwd))."','".mysql_real_escape_string($_SERVER['HTTP_USER_AGENT'])."','".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."','".time()."','')";
mysql_query($query,$chibi_conn);
$bbs_sql = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($cid)."'";
$bbs_query = mysql_query($bbs_sql,$chibi_conn);
$bbs = (object) mysql_fetch_array($bbs_query);
$bbs->op = (object) unserialize($bbs->op);
		$chk = true;
		echo $chk;
mysql_close($chibi_conn);
}
?>