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
	if($i !="0")$cmt = $cmt.",".$picture['no'];
	else $cmt = $picture['no'];
	if($picture['type'] == "picture"){
		delfile("../".$picture['src']);
	}
	$mi = $i;
	}

	$bbs_query = select($cid,$chibi_conn);
		$bbs = (object) mysql_fetch_array($bbs_query);
		$bbs->op = (object) unserialize($bbs->op);
		if($bbs->op->secret=="all"){
		$mi = ($mi+1)*10;
		$point_sql = "UPDATE `xe_point` SET `point` = `point`-'".$mi."' WHERE `member_srl` ='".mysql_real_escape_string($bbs->member_srl)."'";
		mysql_query($point_sql);
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