<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_POST['cid'];
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

$sql2 = "SELECT * FROM `chibi_member` WHERE session='".mysqli_real_escape_string($chibi_conn, session_id())."'";
$query2 = mysqli_query($chibi_conn, $sql2);
$member2 = (object) mysqli_fetch_array($query2);
if(empty($member2->permission)==true) $permission='';
else $permission = $member2->permission;

if($cid && $idx && $pic_no){
	$select = "SELECT * FROM `chibi_comment` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."' AND `idx`='".mysqli_real_escape_string($chibi_conn, $_POST['idx'])."' AND `pic_no`='".mysqli_real_escape_string($chibi_conn, $pic_no)."' AND `passwd`='".mysqli_real_escape_string($chibi_conn, md5($passwd))."'";
	$error = mysqli_query($chibi_conn, $select);
	$cmt = mysqli_fetch_array($error);
		if(empty($error)==true){
			$chk = false;
			echo $chk;
		}else{
			if($cmt['passwd']==md5($passwd)){
				
				$bbs = mysqli_fetch_array(select($cid,$chibi_conn));
				$bbs_op = unserialize($bbs['op']);
				$point = $bbs_op['comment_point'];
				
				$select = "SELECT * FROM `chibi_comment` WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."'";
				$s_query = mysqli_query($chibi_conn, $select);
				$comment = mysqli_fetch_array($s_query);
				$commentop = unserialize($comment["op"]);
				$user_id = $commentop['user_id'];
				if(empty($user_id)==false){
					$p_sql = "UPDATE `chibi_member` SET `point` = point-'".mysqli_real_escape_string($chibi_conn, $point)."' , `comment` = comment-'1' WHERE `user_id` = '".mysqli_real_escape_string($chibi_conn, $user_id)."'";
				}
				mysqli_query($chibi_conn, $p_sql);
				
				
				$query = "DELETE FROM `chibi_comment` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."' AND `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."' AND `pic_no`='".mysqli_real_escape_string($chibi_conn, $pic_no)."' AND `passwd`='".mysqli_real_escape_string($chibi_conn, md5($passwd))."'";
				 mysqli_query($chibi_conn, $query);
				$chk = true;
				echo $chk;
			}else{
				$chk = false;
				echo $chk;
			}
		}
}else{
	$chk = false;
	echo $chk;
}
mysqli_close($chibi_conn);
?>