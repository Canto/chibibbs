<?php
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
session_start();
/* register_globals = off 환경 변수 재설정 */
foreach($_POST as $key => $value){ 
global ${$key};
if(!get_magic_quotes_gpc()) ${$key} = addslashes($value); /* magic_quotes_gpc가 off일경우 slashes설정 */
else ${$key} = $value;
}

/* DB설정파일 변수설정 */
$HOSTNAME = $host;
$USERNAME = $dbuser;
$DBPASSWD = $dbpass;
$DBNAME = $dbname;
$S_ADMIN_ID = $admin_id;
$S_ADMIN_PASSWD = $admin_pass;

require_once "lib/db.conn.php";

if(is_resource($chibi_conn)) $db_check = true;
else $db_check = false;
$php = phpversion();
if(version_compare($php,'5.0','>'))$php_check = true;
else $php_check = false;
$mysql = mysql_get_server_info($chibi_conn);
if(version_compare($mysql,'5.0','>')) $mysql_check = true;
else $mysql_check = false;
$query = mysql_query("SHOW CHARACTER SET WHERE `Charset`='utf8';",$chibi_conn);
$array = mysql_fetch_array($query);
$encoding = $array['Default collation'];
if($encoding == 'utf8_general_ci') $encoding_check = true;
else $encoding_check = false;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 설치</title>
<style type="text/css">
body{margin:20px;background:#e8e8e8;}
#installed {width:70%;margin:0 auto;padding:20px;}
#installed > a.close {right:0 !important;}
th {background:#d9edf7;}
tbody {background:#ffffff;}
</style>
</head>
<body>
<?php
if($db_check == false){/* DB 정보가 틀렸을 경우 */
?>
<div id="installed" class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
DB 정보가 틀립니다. 호스팅업체에서 다시 확인하시기 바랍니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<script type="text/javascript">
$('#installed').bind('closed', function () {
  history.go(-1);
})
</script>
<?php
}else{
?>

<div id="installed">
<table class="table table-bordered span8 offset2">
	<caption>치비 BBS 설치 가능 여부 체크</caption>
	<thead>
	<tr>
	<th class="info"></th>
	<th class="info">내 서버 정보</th>
	<th class="info">설치 최소 사양(권장 사양)</th>
	<th class="info">설치 가능 여부</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td>PHP 버젼</td>
	<td><p class="text-info"><?=$php?></p></td>
	<td><p class="text-info">5.0 ( 5.1.3 이상 )</p></td>
	<td><?php if($php_check==true){ echo "<p class=\"text-success\">설치가능</p>";}else{ echo "<p class=\"text-error\">설치불가</p>";}?></td>
	</tr>
	<tr>
	<td>Mysql 버젼</td>
	<td><p class="text-info"><?=$mysql?></p></td>
	<td><p class="text-info">5.0</p></td>
	<td><?php if($mysql_check==true){ echo "<p class=\"text-success\">설치가능</p>";}else{ echo "<p class=\"text-error\">설치불가</p>";}?></td>
	</tr>
	<tr>
	<td>Mysql 인코딩(UTF-8)체크</td>
	<td colspan="3"><?php if($encoding_check==true){ echo "<p class=\"text-success\">UTF-8 지원</p>";}else{ echo "<p class=\"text-error\">UTF-8 지원안함</p>";}?></td>
	</tr>
	<tr>
			<td colspan="4">
			<form method="post" id="install" action="install.ok.php" class="form-horizontal">
			<input type="hidden" name="mode" value="install">
			<input type="hidden" name="type" value="install">
			<input type="hidden" name="host" value="<?=$host?>">
			<input type="hidden" name="dbuser" value="<?=$dbuser?>">
			<input type="hidden" name="dbpass" value="<?=$dbpass?>">
			<input type="hidden" name="dbname" value="<?=$dbname?>">
			<input type="hidden" name="admin_id" value="<?=$admin_id?>">
			<input type="hidden" name="admin_pass" value="<?=$admin_pass?>">
			<input type="hidden" name="nickname" value="<?=$nickname?>">
			<div class="control-group">
			<?php if(($php_check && $mysql_check && $encoding_check) == true){
			?>
			<button type="submin" class="btn btn-primary">다음 단계</button>
			<?
			}else{
			?>
			<a class=\"btn btn-primary\" href=\"install.setup.php\">돌아가기</a><span class=\"help-block\">오류 항목이 있습니다. 오류 항목을 확인하세요.</span>
			<?php
			}
			?>
			</div>
			</form>
			</td>
	</tbody>
</table>
</div>


<?php
}
/*
설치 체크 종료
*/
?>

</body>
</html>