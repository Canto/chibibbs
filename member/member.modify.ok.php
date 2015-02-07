<?php
/**
 * Created by PhpStorm.
 * User: canto87
 * Date: 2015/02/07
 * Time: 23:56
 */

if(!defined("__CHIBI__")) exit();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=memberModify')){ /* 접속경로 체크 */
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

	//패스워드가 변경되지 않았을 때
	if(empty($passwd) || $member->passwd == $passwd) $passwd = $member->passwd;

	$op = serialize($op); /* 배열의 직렬화 */
	$sql = "UPDATE `chibi_member` SET `nickname` = '".mysql_real_escape_string($nickname)."' , `profile` = '".mysql_real_escape_string($profile)."' , `passwd` = '".mysql_real_escape_string($passwd)."' WHERE `user_id` = '".mysql_real_escape_string($member->user_id)."'";


	mysql_query($sql,$chibi_conn);
	$error = mysql_error();

}else{
	$connect_page = false;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	<title>Chibi Tool BBS ver <?=$chibi_ver?> 멤버 수정</title>
	<style type="text/css">
		body{margin:0px;background:#fcfcfc;}
		.count{background:#d9edf7;}
		.content{background:#ffffff;}
		.logo{color:#ffffff !important;}
		.margin70{margin-top:50px;}
		.margin20{margin-top:20px;}
		th{font-size:12px;}
		td{font-size:12px;}
		.messageDiv{display:none !important;top:30%;position:fixed;}
		#board-create input,#board-create select,#board-create textarea{font-size:12px;}
		#board-create .td-left{background:#eeeeee;font-size:12px;}
		#board-create .td-right{background:#ffffff;font-size:12px;}
	</style>
</head>
<body>
<div class="row-fluid">
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
			<?php echo $user_id;?> 멤버정보 수정에 실패하였습니다.<br/>에러내용 : <?php echo $error;?><br/>
			<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
		</div>
	<?php
	}else if(empty($error)==true){
		?>
		<div class="alert alert-success">
			<a class="close" href="javascript:history.go(-1);">&times;</a>
			<?php echo $sql;?> 멤버정보 수정을 완료하였습니다.<br/><br/>
			<!--<a class="btn btn-success" href="admin.php?cAct=adminMemberAdd">완료</a>-->
		</div>
	<?php
	}
	?>
</div>
	</div>
</body>
</html>
