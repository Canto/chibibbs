<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminSkinTpl')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
$cid = $_POST['cid'];
$skin = $_POST['skin'];
$tpl = $_POST['tpl'];
if(get_magic_quotes_gpc()) $tpl = stripslashes($tpl); /* magic_quotes_gpc가 off일경우 slashes설정 */
else $tpl = $tpl;

$tpl = htmlspecialchars_decode($tpl);

$error='';

$tpl = str_replace("\$HOSTNAME","'error'",$tpl);
$tpl = str_replace("\$USERNAME","'error'",$tpl);
$tpl = str_replace("\$DBPASSWD","'error'",$tpl);
$tpl = str_replace("\$DBNAME","'error'",$tpl);
$tpl = str_replace("mysql_query","'error'",$tpl);
$tpl = str_replace("mysql_result","'error'",$tpl);
$tpl = str_replace("MYSQL_QUERY","'error'",$tpl);

/* 입력 값 설정 */
$tpl_file=fopen("../data/".$cid."/tpl/$cid.tpl.php","w");
if($tpl_file){
fwrite($tpl_file,$tpl);

if(file_exists("../skin/".$skin."/user.fn.php")){
	require_once '../skin/'.$skin.'/user.fn.php';
	if(function_exists('user_convert')){
		$content = user_convert($tpl);
	}else{
		$content = convert($tpl);
	}
}else{
	$content = convert($tpl);
}

compiled($cid,$content);

}else{
$error = "템플릿 파일 열기 실패!!";
}
fclose($tpl_file);
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
게시판의 템플릿 저장에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 게시판의 템플릿 저장을 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminSkinTpl&cid=<?php echo $cid; ?>&skin=<?php echo $skin; ?>">완료</a>
</div>
<?php
}
?>
</div>
