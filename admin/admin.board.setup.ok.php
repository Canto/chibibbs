<?php
if(!defined("__CHIBI__")) exit();
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


$skin_select_sql = "SELECT * FROM `chibi_skin` where `cid`='".mysql_real_escape_string($cid)."'";
$skin_select_query = mysql_query($skin_select_sql,$chibi_conn);
$skin_select = mysql_fetch_array($skin_select_query);

if($skin_select['skin_name']!=$skin){
	include_once '../skin/'.$skin.'/skin.sql.php';
	mysql_query($uskin_db,$chibi_conn);
	
	
	$tpl=fopen("../data/".$cid."/tpl/".$cid.".tpl.php","r");
	$tpl_file = '';
	while (!feof($tpl)){
		$tpl_file = $tpl_file.fgets($tpl);
	}
	fclose($tpl);
	$tpl_file = htmlspecialchars($tpl_file);
	$reset_tpl=fopen("../skin/".$skin."/layout.php","r");
	$reset_tpl_file = '';
	while (!feof($reset_tpl)){
		$reset_tpl_file = $reset_tpl_file.fgets($reset_tpl);
	}
	fclose($reset_tpl);
	
	/* 입력 값 설정 */
	$tpl_file=fopen("../data/".$cid."/tpl/$cid.tpl.php","w");
	if($tpl_file){
		fwrite($tpl_file,$reset_tpl_file);
		
		if(file_exists("../skin/".$skin."/user.fn.php")){
			require_once '../skin/'.$skin.'/user.fn.php';
			if(function_exists('user_convert')){
				$content = user_convert($reset_tpl_file);
			}else{
				$content = convert($reset_tpl_file);
			}
		}else{
			$content = convert($reset_tpl_file);
		}
		
		compiled($cid,$content);
	}else{
		$error = "템플릿 파일 열기 실패!!";
	}
	fclose($tpl_file);
	
	
}
if($ncid!=$cid){
$sql = "UPDATE `chibi_admin` SET `cid` = '".mysql_real_escape_string($ncid)."', `skin` = '".mysql_real_escape_string($skin)."', `passwd` = '".mysql_real_escape_string($passwd)."', `title` = '".mysql_real_escape_string($title)."', `notice` = '".mysql_real_escape_string($notice)."', `tag` = '".mysql_real_escape_string($tag)."', `spam` = '".mysql_real_escape_string($spam)."', `op` = '".mysql_real_escape_string($option)."' WHERE `cid` = '".mysql_real_escape_string($cid)."'"; 
mysql_query($sql,$chibi_conn);
$error = mysql_error();
$skin_sql = "UPDATE `chibi_skin` SET `cid` = '".mysql_real_escape_string($ncid)."' WHERE `cid` = '".mysql_real_escape_string($cid)."'";
mysql_query($skin_sql,$chibi_conn);
$error .= mysql_error();
$log_sql = "UPDATE `chibi_log` SET `cid` = '".mysql_real_escape_string($ncid)."' WHERE `cid` = '".mysql_real_escape_string($cid)."'";
mysql_query($log_sql,$chibi_conn);
$error .= mysql_error();
$comment_sql = "UPDATE `chibi_comment` SET `cid` = '".mysql_real_escape_string($ncid)."' WHERE `cid` = '".mysql_real_escape_string($cid)."'";
mysql_query($comment_sql,$chibi_conn);
if(rename("../data/".$cid,"../data/".$ncid)){
	rename("../data/".$ncid."/tpl/".$cid.".tpl.php","../data/".$ncid."/tpl/".$ncid.".tpl.php");
	rename("../data/".$ncid."/tpl/".$cid.".tpl.compiled.php","../data/".$ncid."/tpl/".$ncid.".tpl.compiled.php");
	$repath_sql = "UPDATE `chibi_pic` SET `cid` = '".mysql_real_escape_string($ncid)."', `src` = REPLACE(src,'".mysql_real_escape_string($cid)."','".mysql_real_escape_string($ncid)."') WHERE `cid` = '".mysql_real_escape_string($cid)."'";
	mysql_query($repath_sql,$chibi_conn);
}
}else{
$sql = "UPDATE `chibi_admin` SET `cid` = '".mysql_real_escape_string($cid)."', `skin` = '".mysql_real_escape_string($skin)."', `passwd` = '".mysql_real_escape_string($passwd)."', `title` = '".mysql_real_escape_string($title)."', `notice` = '".mysql_real_escape_string($notice)."', `tag` = '".mysql_real_escape_string($tag)."', `spam` = '".mysql_real_escape_string($spam)."', `op` = '".mysql_real_escape_string($option)."' WHERE `cid` = '".mysql_real_escape_string($cid)."'";
mysql_query($sql,$chibi_conn);
$error = mysql_error();

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
<?php echo $ncid; ?> 게시판의 설정 저장을 완료하였습니다.<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminBoardSetup&cid=<?php echo $ncid; ?>">완료</a>
</div>
<?php
}
?>
</div>
