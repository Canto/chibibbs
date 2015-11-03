<?php
if(!defined("__CHIBI__")) exit();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminBoardList')){ /* 접속경로 체크 */
$connect_page=true;
$cid = $_GET['cid'];

if($member->permission=="all" || $member->permission=="super"){
	$member_permission = "all";
	$error='';
	$sql = "DELETE FROM `chibi_admin` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	mysqli_query($chibi_conn, $sql);
	$error = mysqli_error($chibi_conn);
	if(empty($error)==true){
		$sql2 = "DELETE FROM `chibi_emoticon` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	mysqli_query($chibi_conn, $sql2);
	$sql3 = "DELETE FROM `chibi_skin` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	mysqli_query($chibi_conn, $sql3);
	$sql4 = "DELETE FROM `chibi_tpl` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	mysqli_query($chibi_conn, $sql4);
	$sql5 = "DELETE FROM `chibi_pic` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	mysqli_query($chibi_conn, $sql5);
	$sql6 = "DELETE FROM `chibi_comment` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."'";
	mysqli_query($chibi_conn, $sql6);
	rmdir_rf("../data/".$cid."/emoticon");
	rmdir_rf("../data/".$cid."/tpl");
	rmdir_rf("../data/".$cid);
	}
}else{
$connect_page=false;
}
}
?>
<div class="span8 offset2">
<?php
if($connect_page == false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
올바른 경로로 접속하여 주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
else if(empty($error)==false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 게시판 삭제에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 게시판 삭제를 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminBoardList">완료</a>
</div>
<?php
}
?>
</div>