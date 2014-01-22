<?php
if(!defined("__CHIBI__")) exit();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminBoardList')){ /* 접속경로 체크 */
$connect_page=true;
$cid = $_GET['cid'];

if($member->permission=="all" || $member->permission=="super"){
	$member_permission = "all";
	$error='';
	$sql = "DELETE FROM `chibi_admin` WHERE `cid`='".mysql_real_escape_string($cid)."'";
	mysql_query($sql,$chibi_conn);
	$error = mysql_error();
	if(empty($error)==true){
		$sql2 = "DELETE FROM `chibi_emoticon` WHERE `cid`='".mysql_real_escape_string($cid)."'";
	mysql_query($sql2,$chibi_conn);
	$sql3 = "DELETE FROM `chibi_skin` WHERE `cid`='".mysql_real_escape_string($cid)."'";
	mysql_query($sql3,$chibi_conn);
	$sql4 = "DELETE FROM `chibi_tpl` WHERE `cid`='".mysql_real_escape_string($cid)."'";
	mysql_query($sql4,$chibi_conn);
	$sql5 = "DELETE FROM `chibi_pic` WHERE `cid`='".mysql_real_escape_string($cid)."'";
	mysql_query($sql5,$chibi_conn);
	$sql6 = "DELETE FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($cid)."'";
	mysql_query($sql6,$chibi_conn);
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