<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminBoardCreate')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}
$error='';
$error_tpl='';
if($_POST['inst']) $arry_inst = implode($_POST['inst'],",");
else $arry_inst = '';
if($_POST['position']) $arry_position = implode($_POST['position'],",");
else $arry_position = '';
if($_POST['inst2']) $arry_inst2 = implode($_POST['inst2'],",");
else $arry_inst2 = '';
if($_POST['position2']) $arry_position2 = implode($_POST['position2'],",");
else $arry_position2 = '';
/* 입력 값 설정 */
$option = array( /* 옵션 입력 값 */
	'secret'=>$secret,
	'use_permission'=>$use_permission,
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
	'inst'=>$arry_inst,
	'position'=>$arry_position,
	'inst2'=>$arry_inst2,
	'position2'=>$arry_position2,
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

$sql = "INSERT INTO `chibi_admin` (
`cid`, `skin`, `passwd`, `permission`, `title`, `notice`, `tag`, `spam`, `op`) VALUES ('".mysqli_real_escape_string($chibi_conn, $cid)."', '".mysqli_real_escape_string($chibi_conn, $skin)."', '".mysqli_real_escape_string($chibi_conn, md5($passwd))."', '', '".mysqli_real_escape_string($chibi_conn, $title)."', '".mysqli_real_escape_string($chibi_conn, $notice)."', '".mysqli_real_escape_string($chibi_conn, $tag)."', '".mysqli_real_escape_string($chibi_conn, $spam)."', '".mysqli_real_escape_string($chibi_conn, $option)."');";

/*
ob_start();
include_once "skin/".$skin."/layout.php";
$tpl = ob_get_contents();
ob_end_clean();
$tpl_insert_string = "INSERT INTO `chibi_tpl` (`cid`, `skin`, `tpl`, `css` ) VALUES ('".mysqli_real_escape_string($chibi_conn, $cid)."', '".mysqli_real_escape_string($chibi_conn, $skin)."', '".mysqli_real_escape_string($chibi_conn, $tpl)."','');";
*/

if(is_writable("../data/")){
if(is_dir("../data/".$cid)==false){
	$data_permission = true;
		umask(0);
		mkdir("../data/".$cid,0755);
		mkdir("../data/".$cid."/emoticon",0755);
		if(is_dir("../data/".$cid)==true && is_dir("../data/".$cid."/emoticon")==true) $mkdir = true;
		else $mkdir = false;
		mkdir("../data/".$cid."/tpl",0755);
		
/* 템플릿 초기 설정 */
$tpl = fopen("../skin/".$skin."/layout.php", "r");
$tpl_file = '';
while (!feof($tpl)){
$tpl_file = $tpl_file.fgets($tpl);
}
$fp=fopen("../data/".$cid."/tpl/".$cid.".tpl.php","w");
fwrite($fp,$tpl_file);
fclose($fp);
fclose($tpl);
chmod("../data/".$cid."/tpl/".$cid.".tpl.php",0644);

if(file_exists("../skin/".$skin."/user.fn.php")){
	require_once '../skin/'.$skin.'/user.fn.php';
	if(function_exists('user_convert')){
		$content = user_convert($tpl_file);
	}else{
		$content = conveert($tpl_file);
	}
}else{
	$content = convert($tpl_file);
}

$fp=fopen("../data/".$cid."/tpl/".$cid.".tpl.compiled.php","w");
fwrite($fp,$content);
fclose($fp);
chmod("../data/".$cid."/tpl/".$cid.".tpl.compiled.php",0644);

}
}else{
	$data_permission = false;
}

if($mkdir==true){
/* 스킨 초기 설정 로드 */
	include_once "../skin/".$skin."/skin.sql.php";
	mysqli_query($chibi_conn, $skin_insert_string);
	mysqli_query($chibi_conn, $sql);
	$error = mysqli_error($chibi_conn);
/*	mysqli_query($tpl_insert_string,$chibi_conn);
	$error_tpl = mysqli_error($chibi_conn);
	*/
}
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
else if($data_permission == false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
data 폴더의 권한이 755 혹은 707 이 아닙니다.<br/>권한을 변경하여 주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
else if(empty($error)==false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
게시판 생성에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/><?php echo $error_tpl;?><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==true && $mkdir==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 게시판의 생성을 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminBoardCreate">완료</a>
</div>
<?php
}
?>
</div>
