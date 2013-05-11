<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_GET['cid'];
$page = $_GET['page'];
$pic_no = $_POST['pic_no'];
$idx = $_POST['idx'];
$session = $_POST['member'];

if(empty($_POST['passwd'])==false){
	$passwd = $_POST['passwd'];
}
else{
	$passwd = time();
}


/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

$sql2 = "SELECT * FROM `chibi_member` WHERE session='".mysql_real_escape_string(session_id())."'";
$query2 = mysql_query($sql2,$chibi_conn);
$member2 = (object) mysql_fetch_array($query2);
if(empty($member2->permission)==true) $permission='';
else $permission = $member2->permission;

if($cid && $idx && $pic_no){
	$select = "SELECT * FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($cid)."' AND `idx`='".mysql_real_escape_string($_POST['idx'])."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' AND `passwd`='".mysql_real_escape_string(md5($passwd))."'";
	$error = mysql_query($select,$chibi_conn);
	$error = mysql_fetch_row($error);
		if(empty($error)==true){
			echo "<script>alert('코멘트 삭제 실패!!');
			history.go(-1);
			</script>";
		}else{
		$query = "DELETE FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($cid)."' AND `idx`='".mysql_real_escape_string($idx)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' AND `passwd`='".mysql_real_escape_string(md5($passwd))."'";
		 mysql_query($query,$chibi_conn);
		echo "<script>alert('코멘트 삭제 완료!!');
		location.href = '../index.php?cid=".$cid."&page=".$page."';
		</script>";
		}
}else{
	echo "<script>alert('코멘트 삭제 실패!!');
			history.go(-1);
			</script>";
}
mysql_close($chibi_conn);
?>