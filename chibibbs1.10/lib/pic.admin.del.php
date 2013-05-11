<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
$page = $_POST['page'];
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




if(bbs_permission($member2->permission,$cid)=="true" && empty($idx)==false){
	$cmt ='';	
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
	}

	$query = "DELETE FROM `chibi_pic` WHERE `idx` IN (".mysql_real_escape_string($idx_cmt).")";
	$query2 = "DELETE FROM `chibi_comment` WHERE `pic_no` IN (".mysql_real_escape_string($cmt).") AND `cid`='".mysql_real_escape_string($cid)."'";
	//echo $query;
	mysql_query($query,$chibi_conn);
	mysql_query($query2,$chibi_conn);
	echo "<script>alert('그림 삭제 완료!!');
	location.href = '../index.php?cid=".$cid."&page=".$page."';
	</script>";
	
}else{
	echo "<script>alert('그림 삭제 실패!!');
	history.go(-1);
	</script>";
}
mysql_close($chibi_conn);
?>