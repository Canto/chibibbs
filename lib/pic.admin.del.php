<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
//$src = $_POST['src'];
//$type = $_POST['type'];
$idx = explode("&",$_POST['idx']);
$idx_cmt = '';



/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

$sql2 = "SELECT * FROM `chibi_member` WHERE session='".mysql_real_escape_string(session_id())."'";
$query2 = mysql_query($sql2,$chibi_conn);
$member2 = (object) mysql_fetch_array($query2);
$bbs = mysql_fetch_array(select($cid,$chibi_conn));
$bbs_op = unserialize($bbs['op']);
$point = $bbs_op['pic_point'];



if(bbs_permission($member2->permission,$cid)=="true"){
	$cmt ='';	
	$mi ='';
	for($i=0;$i<count($idx);$i++){
	$tmp = '';
	$tmp = explode("=",$idx[$i]);
	if($i !="0")$idx_cmt = $idx_cmt.",".$tmp[1];
	else $idx_cmt = $tmp[1];


	$select = "SELECT * FROM `chibi_pic` WHERE `idx`='".mysql_real_escape_string($tmp[1])."'";
	$s_query = mysql_query($select,$chibi_conn);
	$picture = mysql_fetch_array($s_query);
	$picop = unserialize($picture["op"]);
	$user_id = $picop['user_id'];
	if(empty($user_id)==false){
		$p_sql = "UPDATE `chibi_member` SET `point` = point-'".mysql_real_escape_string($point)."' , `pic`=pic-'1' WHERE `user_id` = '".mysql_real_escape_string($user_id)."'";
	}
	mysql_query($p_sql,$chibi_conn);
	
	if($i !="0")$cmt = $cmt.",".$picture['no'];
	else $cmt = $picture['no'];
	if($picture['type'] == "picture"){
		delfile("../".$picture['src']);
	}
	$mi = $i;
	}


	

	$query = "DELETE FROM `chibi_pic` WHERE `idx` IN (".mysql_real_escape_string($idx_cmt).")";
	$query2 = "DELETE FROM `chibi_comment` WHERE `pic_no` IN (".mysql_real_escape_string($cmt).") AND `cid` = '".mysql_real_escape_string($cid)."'";
	//echo $query;
	mysql_query($query,$chibi_conn);
	mysql_query($query2,$chibi_conn);

		$chk = true;
		echo $chk;
	
}else{

	$chk = false;
	echo $chk;
}
mysql_close($chibi_conn);
?>