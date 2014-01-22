<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminMemberSetup')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}
$permission = $_POST['permission'];
$error='';
/* 비공개 비밀번호가 입력되었을 경우 */
if(empty($passwd)==false){
	$passwd = md5($passwd);
}else{
	$query = member_list($user_id,$chibi_conn);
	$member_list = (object) mysql_fetch_array($query);
	$passwd = $member_list->passwd;
}
$permission = implode(",",$permission);
/* 입력 값 설정 */

$profile = array( /* 프로필 입력 값 */
	'img1'=>$img1,
	'img2'=>$img2,
	'img3'=>$img3,
	'text'=>$text
);
$profile = serialize($profile); /* 배열의 직렬화 */

$op = array(); /* 옵션 입력 값 */

$op = serialize($op); /* 배열의 직렬화 */


$sql = "UPDATE `chibi_member` SET `user_id` = '".mysql_real_escape_string($user_id)."', `nickname` = '".mysql_real_escape_string($nickname)."', `passwd` = '".mysql_real_escape_string($passwd)."', `permission` = '".mysql_real_escape_string($permission)."', `profile` = '".mysql_real_escape_string($profile)."', `point` = '".mysql_real_escape_string($point)."', `op` = '".mysql_real_escape_string($op)."' WHERE `user_id` = '".mysql_real_escape_string($user_id)."'";

mysql_query($sql,$chibi_conn);
$error = mysql_error();

}else{
	$connect_page = false;
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
<?php echo $user_id; ?> 멤버의 정보 수정을 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $user_id; ?> 멤버의 정보 수정을 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminMemberSetup&user_id=<?php echo $user_id; ?>">완료</a>
</div>
<?php
}
?>
</div>
