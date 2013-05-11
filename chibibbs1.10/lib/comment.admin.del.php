<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
$page = $_POST['page'];
$idx = explode("&",$_POST['idx']);
$idx_cmt = '';

for($i=0;$i<count($idx);$i++){
	$tmp = '';
	$tmp = explode("=",$idx[$i]);
	if($i !="0")$idx_cmt = $idx_cmt.",".$tmp[1];
	else $idx_cmt = $tmp[1];
}

/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

$sql2 = "SELECT * FROM `chibi_member` WHERE session='".mysql_real_escape_string(session_id())."'";
$query2 = mysql_query($sql2,$chibi_conn);
$member2 = (object) mysql_fetch_array($query2);


if(bbs_permission($member2->permission,$cid)=="true" && empty($idx)==false){

	$query = "DELETE FROM `chibi_comment` WHERE `idx` IN (".mysql_real_escape_string($idx_cmt).") AND `cid`='".mysql_real_escape_string($cid)."'";
	//echo $query;
	mysql_query($query,$chibi_conn);
	echo "<script>alert('코멘트 삭제 완료!!');
	location.href = '../index.php?cid=".$cid."&page=".$page."';
	</script>";
	
}else{
	echo "<script>alert('코멘트 삭제 실패!!');
	history.go(-1);
	</script>";
}
mysql_close($chibi_conn);
?>