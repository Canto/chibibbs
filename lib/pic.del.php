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

	$select = "SELECT * FROM `chibi_pic` WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."' AND `passwd`='".mysqli_real_escape_string($chibi_conn, md5($passwd))."'";
	$s_query = mysqli_query($chibi_conn, $select);
	$picture = mysqli_fetch_array($s_query);
	if(empty($picture['idx'])==true){
			$chk = false;
			echo $chk;
	}else{
	if($picture['type'] == "picture"){
		delfile("../".$picture['src']);
	}
	
	$bbs = mysqli_fetch_array(select($cid,$chibi_conn));
	$bbs_op = unserialize($bbs['op']);
	$point = $bbs_op['pic_point'];
	$picop = unserialize($picture["op"]);
	$user_id = $picop['user_id'];
	if(empty($user_id)==false){
		$p_sql = "UPDATE `chibi_member` SET `point` = point-'".mysqli_real_escape_string($chibi_conn, $point)."', `pic`=pic-'1' WHERE `user_id` = '".mysqli_real_escape_string($chibi_conn, $user_id)."'";
		mysqli_query($chibi_conn, $p_sql);
	}
	$query = "DELETE FROM `chibi_pic` WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."' AND `cid` = '".mysqli_real_escape_string($chibi_conn, $cid)."'";
	$cmt_query = "DELETE FROM `chibi_comment` WHERE `pic_no`='".mysqli_real_escape_string($chibi_conn, $picture['no'])."' AND `cid` = '".mysqli_real_escape_string($chibi_conn, $cid)."'";
	//echo $query;
	mysqli_query($chibi_conn, $query);
	mysqli_query($chibi_conn, $cmt_query);
		$chk = true;
		echo $chk;
		}
}else{
	$chk = false;
	echo $chk;
}
mysqli_close($chibi_conn);
?>