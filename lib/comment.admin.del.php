<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
$idx = explode("&",$_POST['idx']);
$idx_cmt = '';


/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

$sql2 = "SELECT * FROM `chibi_member` WHERE session='".mysqli_real_escape_string($chibi_conn, session_id())."'";
$query2 = mysqli_query($chibi_conn, $sql2);
$member2 = (object) mysqli_fetch_array($query2);


if(bbs_permission($member2->permission,$cid)=="true"){
	
	$bbs = mysqli_fetch_array(select($cid,$chibi_conn));
	$bbs_op = unserialize($bbs['op']);
	$point = $bbs_op['comment_point'];
	
	for($i=0;$i<count($idx);$i++){
		$tmp = '';
		$tmp = explode("=",$idx[$i]);
		if($i !="0")$idx_cmt = $idx_cmt.",".$tmp[1];
		else $idx_cmt = $tmp[1];
		
		$select = "SELECT * FROM `chibi_comment` WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $tmp[1])."'";
		$s_query = mysqli_query($chibi_conn, $select);
		$comment = mysqli_fetch_array($s_query);
		$commentop = unserialize($comment["op"]);
		$user_id = $commentop['user_id'];
		if(empty($user_id)==false){
			$p_sql = "UPDATE `chibi_member` SET `point` = point-'".mysqli_real_escape_string($chibi_conn, $point)."', `comment`=comment-'1' WHERE `user_id` = '".mysqli_real_escape_string($chibi_conn, $user_id)."'";
		}
		mysqli_query($chibi_conn, $p_sql);
		
	}

	$query = "DELETE FROM `chibi_comment` WHERE `idx` IN (".mysqli_real_escape_string($chibi_conn, $idx_cmt).") AND `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	//echo $query;
	
	mysqli_query($chibi_conn, $query);
	
	
	$chk = true;
	echo $chk;
	
}else{

	$chk = false;
	echo $chk;
}
mysqli_close($chibi_conn);
?>