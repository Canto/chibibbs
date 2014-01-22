<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
$idx = $_POST['idx'];
$passwd = $_POST['passwd'];

/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

if((empty($cid) && empty($idx))==false){

	$select = "SELECT * FROM `chibi_pic` WHERE `idx`='".mysql_real_escape_string($idx)."' AND `passwd`='".mysql_real_escape_string(md5($passwd))."'";
	$s_query = mysql_query($select,$chibi_conn);
	$picture = mysql_fetch_array($s_query);
	if(empty($picture['idx'])==true){
			$chk = false;
			echo $chk;
	}else{
	if($picture['type'] == "picture"){
		delfile("../".$picture['src']);
	}
	
	$bbs = mysql_fetch_array(select($cid,$chibi_conn));
	$bbs_op = unserialize($bbs['op']);
	$point = $bbs_op['pic_point'];
	$picop = unserialize($picture["op"]);
	$user_id = $picop['user_id'];
	if(empty($user_id)==false){
		$p_sql = "UPDATE `chibi_member` SET `point` = point-'".mysql_real_escape_string($point)."', `pic`=pic-'1' WHERE `user_id` = '".mysql_real_escape_string($user_id)."'";
		mysql_query($p_sql,$chibi_conn);
	}
	$query = "DELETE FROM `chibi_pic` WHERE `idx`='".mysql_real_escape_string($idx)."' AND `cid` = '".mysql_real_escape_string($cid)."'";
	$cmt_query = "DELETE FROM `chibi_comment` WHERE `pic_no`='".mysql_real_escape_string($picture['no'])."' AND `cid` = '".mysql_real_escape_string($cid)."'";
	//echo $query;
	mysql_query($query,$chibi_conn);
	mysql_query($cmt_query,$chibi_conn);
		$chk = true;
		echo $chk;
		}
}else{
	$chk = false;
	echo $chk;
}
mysql_close($chibi_conn);
?>