<?php
if(!defined("__CHIBI__")) exit();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'admin.php')){ /* 접속경로 체크 */
$cid = $_GET['cid'];
$connect_page="true";
	if($member->permission=="all" || $member->permission=="super"){
		$member_permission = "all";
		$error='';
		$sql = "DROP TABLE `chibi_admin`, `chibi_comment`, `chibi_emoticon`, `chibi_log`, `chibi_member`, `chibi_pic`, `chibi_skin`, `chibi_tpl`;";
		mysql_query($sql,$chibi_conn);
		$error = mysql_error();
		if(empty($error)==true){
			function deleteDirectory($dir) {
				if (!file_exists($dir)) return true;
				if (!is_dir($dir)) return unlink($dir);
				foreach (scandir($dir) as $item) {
					if ($item == '.' || $item == '..') continue;
					if (!deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
				}
				return rmdir($dir);
			}
			deleteDirectory("../data");
		}
	}
}else{
	$connect_page="false";
}

?>
<div class="span8 offset2">
<?php
if($connect_page === "false"){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
올바른 경로로 접속하여 주세요.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}else if(empty($error)==false){
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