<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());
$type = $_POST['type'];
$cid = $_POST['cid'];
$passwd = $_POST['passwd'];
$user_id = $_POST['user_id'];
if(empty($_POST['op'])==false){
	$op = $_POST['op'];
}
else{
	$op = '';
}
$op = serialize($op);

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


include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";
include_once "../lib/bbs.fn.php";
$count_sql = "SELECT * FROM `chibi_pic` WHERE `cid`='".mysql_real_escape_string($cid)."' ORDER BY `idx` DESC";
$count_query = mysql_query($count_sql,$chibi_conn);
$count = mysql_fetch_array($count_query);
$query = "INSERT INTO `chibi_pic` (`idx`,`no`,`cid`, `type`, `src`, `passwd`, `agent`, `pic_ip`, `time`, `op`)VALUES('','".mysql_real_escape_string($count['no']+1)."','".mysql_real_escape_string($cid)."','".mysql_real_escape_string($type)."','".mysql_real_escape_string($image)."','".mysql_real_escape_string(md5($passwd))."','".mysql_real_escape_string($_SERVER['HTTP_USER_AGENT'])."','".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."','".time()."','".mysql_real_escape_string($op)."')";
mysql_query($query,$chibi_conn);
if(empty($user_id)==false){
	$bbs = mysql_fetch_array(select($cid,$chibi_conn));
	$bbs_op = unserialize($bbs['op']);
	$point = $bbs_op['pic_point'];
	$p_sql = "UPDATE `chibi_member` SET `point` = point+'".mysql_real_escape_string($point)."', `pic`=pic+'1' WHERE `user_id` = '".mysql_real_escape_string($user_id)."'";
	mysql_query($p_sql,$chibi_conn);
}


$chk = true;
echo $chk;
mysql_close($chibi_conn);
}
?>