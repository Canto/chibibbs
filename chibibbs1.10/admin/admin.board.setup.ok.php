<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminBoardSetup')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}
$error='';
/* 비공개 비밀번호가 입력되었을 경우 */
if(empty($passwd)==false){
	$passwd = md5($passwd);
}else{
	$query = select($cid,$chibi_conn);
	$bbs = (object) mysql_fetch_array($query);
	$passwd = $bbs->passwd;
}

/* 입력 값 설정 */
$option = array( /* 옵션 입력 값 */
	'secret'=>$secret,
	'btool'=>$btool,
	'pic_page'=>$pic_page,
	'pic_page_bar'=>$pic_page_bar,
	'pic_max_width'=>$pic_max_width,
	'pic_max_height'=>$pic_max_height,
	'pic_min_width'=>$pic_min_width,
	'pic_min_height'=>$pic_min_height,
	'pic_d_width'=>$pic_d_width,
	'pic_d_height'=>$pic_d_height,
	'pic_thumbnail_width'=>$pic_thumbnail_width,
	'showip'=>$showip,
	'pic_point'=>$pic_point,
	'comment_point'=>$comment_point,
	'include_head'=>$include_head,
	'include_foot'=>$include_foot
	);
$option = serialize($option); /* 배열의 직렬화 */

$notice = array( /* 공지사항 입력 값 */
	'head'=>$head,
	'foot'=>$foot
	);
$notice = serialize($notice); /* 배열의 직렬화 */

$spam = array( /* 스팸 입력 값 */
	'op'=>$op,
	'ip'=>$ip,
	'word'=>$word
	);
$spam = serialize($spam); /* 배열의 직렬화 */


$sql = "UPDATE `chibi_admin` SET `cid` = '".mysql_real_escape_string($cid)."', `skin` = '".mysql_real_escape_string($skin)."', `passwd` = '".mysql_real_escape_string($passwd)."', `title` = '".mysql_real_escape_string($title)."', `notice` = '".mysql_real_escape_string($notice)."', `tag` = '".mysql_real_escape_string($tag)."', `spam` = '".mysql_real_escape_string($spam)."', `op` = '".mysql_real_escape_string($option)."' WHERE `cid` = '".mysql_real_escape_string($cid)."'";

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
게시판의 설정 저장에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 게시판의 설정 저장을 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminBoardSetup&cid=<?php echo $cid; ?>">완료</a>
</div>
<?php
}
?>
</div>
