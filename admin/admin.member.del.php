<?php
if(!defined("__CHIBI__")) exit();

if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminMemberList')){ /* 접속경로 체크 */
$connect_page=true;
$user_id = $_GET['user_id'];
$query = member_list($user_id,$chibi_conn);
$member_list = (object) mysql_fetch_array($query);
if($member_list->permission == "super"){
$member_permission = "super";
}else{
if($member->permission=="all" || $member->permission=="super"){
$error='';
$sql = "DELETE FROM `chibi_member` WHERE `user_id`='".mysql_real_escape_string($user_id)."'";
mysql_query($sql,$chibi_conn);
$error = mysql_error();
}
}
}else{
$connect_page=false;
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
}else if($member_permission =="super"){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $user_id;?>는 삭제불가능한 멤버입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
else if(empty($error)==false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $user_id; ?> 멤버 삭제에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $user_id; ?> 멤버 삭제를 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminMemberList">완료</a>
</div>
<?php
}
?>
</div>