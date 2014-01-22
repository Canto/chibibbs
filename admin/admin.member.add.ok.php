<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminMemberAdd')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}
$error='';
$permission = $_POST['permission'];
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


$sql = "INSERT INTO `chibi_member` (
`mno`, `user_id`, `nickname`, `passwd`, `permission`, `profile`, `point`, `pic`, `comment`, `op`, `lastlogin`, `session`) VALUES ('', '".mysql_real_escape_string($user_id)."', '".mysql_real_escape_string($nickname)."', '".mysql_real_escape_string(md5($passwd))."', '".mysql_real_escape_string($permission)."', '".mysql_real_escape_string($profile)."', '".mysql_real_escape_string($point)."', '0', '0', '".mysql_real_escape_string($op)."', '', '');";
	
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
<?php echo $user_id;?> 멤버추가에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $user_id;?> 멤버추가를 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminMemberAdd">완료</a>
</div>
<?php
}
?>
</div>
