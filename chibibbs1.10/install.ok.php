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

/* DB Table 생성 확인*/
$db_check = (object) array("status"=>"","admin"=>"","skin"=>"","pic"=>"","comment"=>"","tpl"=>"","member"=>"","emoticon"=>"","log"=>"");
if(is_resource($chibi_conn)) $db_check->status = true;
else $db_check->status = false;
if(is_resource(@mysql_query("DESC chibi_admin",$chibi_conn))) $db_check->admin = true;
else $db_check->admin = false;
if(is_resource(@mysql_query("DESC chibi_skin",$chibi_conn))) $db_check->skin = true;
else $db_check->skin = false;
if(is_resource(@mysql_query("DESC chibi_pic",$chibi_conn))) $db_check->pic = true;
else $db_check->pic = false;
if(is_resource(@mysql_query("DESC chibi_comment",$chibi_conn))) $db_check->comment = true;
else $db_check->comment = false;
if(is_resource(@mysql_query("DESC chibi_tpl",$chibi_conn))) $db_check->tpl = true;
else $db_check->tpl = false;
if(is_resource(@mysql_query("DESC chibi_member",$chibi_conn))) $db_check->member = true;
else $db_check->member = false;
if(is_resource(@mysql_query("DESC chibi_emoticon",$chibi_conn))) $db_check->emoticon = true;
else $db_check->emoticon = false;
if(is_resource(@mysql_query("DESC chibi_log",$chibi_conn))) $db_check->log = true;
else $db_check->log = false;

if($db_check->status == true){
if(is_file(dirname(__FILE__)."/data/config/db.config.php")==false){
/*
DB설정파일 db.config.php 가 없을 경우
*/
$config_string = "<?php
if(!defined(\"__CHIBI__\")) exit();
\$HOSTNAME =\"{$HOSTNAME}\";
\$USERNAME =\"{$USERNAME}\";
\$DBPASSWD =\"{$DBPASSWD}\";
\$DBNAME =\"{$DBNAME}\";
?>";
	if(is_dir(dirname(__FILE__)."/data/config")==false){ /* config 폴더가 없을경우 */
		mkdir(dirname(__FILE__)."/data/config",0755);
		$db_config_file = fopen(dirname(__FILE__)."/data/config/db.config.php","w");
		fwrite($db_config_file,$config_string);
		chmod(dirname(__FILE__)."/data/config/db.config.php",0644);
		fclose($db_config_file);
	}else{ /* 있을경우 */
		if(!is_writable(dirname(__FILE__)."/data/config")){ /* 쓰기 불가 상태일 경우 */
			chmod(dirname(__FILE__)."/data/config",0755);
			$db_config_file = fopen(dirname(__FILE__)."/data/config/db.config.php","w");
			fwrite($db_config_file,$config_string);
			chmod(dirname(__FILE__)."/data/config/db.config.php",0644);
			fclose($db_config_file);
		}else{ /* 쓰기 가능한 상태일 경우 */ 
			$db_config_file = fopen(dirname(__FILE__)."/data/config/db.config.php","w");
			fwrite($db_config_file,$config_string);
			chmod(dirname(__FILE__)."/data/config/db.config.php",0644);
			fclose($db_config_file);
		}
	}
}

/* sql */
$admin_string = "CREATE TABLE `chibi_admin` (
`cid` VARCHAR(255) NOT NULL,
`skin` VARCHAR(255) NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`permission` VARCHAR(255) NOT NULL,
`title` VARCHAR(255) NOT NULL,
`notice` LONGTEXT NOT NULL,
`tag` TEXT NOT NULL,
`spam` LONGTEXT NOT NULL,
`op` LONGTEXT NOT NULL,
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$skin_string = "CREATE TABLE `chibi_skin` (
`cid` VARCHAR(255) NOT NULL,
`skin_name` VARCHAR(255) NOT NULL,
`op` LONGTEXT NOT NULL,
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$pic_string = "CREATE TABLE `chibi_pic` (
`idx` BIGINT NOT NULL AUTO_INCREMENT,
`no` INT NOT NULL,
`cid` VARCHAR(255) NOT NULL,
`type` VARCHAR(255) NOT NULL,
`src` TEXT NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`agent` VARCHAR(255) NOT NULL,
`pic_ip` VARCHAR(255) NOT NULL,
`time` INT(10) NOT NULL,
`op` LONGTEXT NOT NULL,
PRIMARY KEY (`idx`),
INDEX (`no`, `cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$comment_string ="CREATE TABLE `chibi_comment` (
`idx` BIGINT NOT NULL AUTO_INCREMENT,
`cid` VARCHAR(255) NOT NULL,
`pic_no` INT(10) NOT NULL,
`no` INT(10) NOT NULL,
`depth` INT(10) NOT NULL,
`name` VARCHAR(255) NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`rtime` INT(10) NOT NULL,
`comment` LONGTEXT NOT NULL,
`memo` VARCHAR(255) NOT NULL,
`hpurl` VARCHAR(255) NOT NULL,
`ip` VARCHAR(255) NOT NULL,
`op` LONGTEXT NOT NULL,
PRIMARY KEY (`idx`),
INDEX (`cid`, `pic_no`),
FULLTEXT(`comment`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$member_string = "CREATE TABLE `chibi_member` (
`mno` INT NOT NULL AUTO_INCREMENT,
`user_id` VARCHAR(255) NOT NULL,
`nickname` VARCHAR(255) NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`permission` VARCHAR(255) NOT NULL,
`profile` TEXT NOT NULL,
`point` INT(10) NOT NULL,
`pic` INT(10) NOT NULL,
`comment` INT(10) NOT NULL,
`op` LONGTEXT NOT NULL,
`lastlogin` INT(10) NOT NULL,
`session` VARCHAR(255) NOT NULL,
PRIMARY KEY (`mno`),
INDEX (`user_id`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$emoticon_string = "CREATE TABLE `chibi_emoticon` (
cid varchar(255) NOT NULL,
inst varchar(255) NOT NULL,
url text NOT NULL,INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$tpl_string = "CREATE TABLE `chibi_tpl` (
`cid` VARCHAR(255) NOT NULL,
`skin` VARCHAR(255) NOT NULL,
`tpl` LONGTEXT NOT NULL,
`css` LONGTEXT NOT NULL,
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
$log_string = "CREATE TABLE `chibi_log` (
`cid` VARCHAR(255) NOT NULL,
`ip` VARCHAR(255) NOT NULL,
`session` VARCHAR(255) NOT NULL,
`date` INT(10) NOT NULL,
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

/* admin 초기 옵션 */
$admin_option = array(
'secret'=>'off',
'use_permission'=>'all',
'btool'=>'off',
'include_head'=>'',
'include_foot'=>'',
'pic_page'=>'5',
'pic_page_bar'=>'10',
'pic_max_width'=>'1000',
'pic_max_height'=>'1000',
'pic_min_width'=>'50',
'pic_min_height'=>'50',
'pic_d_width'=>'300',
'pic_d_height'=>'300',
'pic_thumbnail_width'=>'500',
'showip'=>'off',
'pic_point'=>'10',
'comment_point'=>'5'
);

/* 기본 게시판 폴더 생성 */
if(is_dir(dirname(__FILE__)."/data/free")==false){
		umask(0);
		mkdir(dirname(__FILE__)."/data/free",0755);
		mkdir(dirname(__FILE__)."/data/free/tpl",0755);
		mkdir(dirname(__FILE__)."/data/free/emoticon",0755);
}else{
	if(!is_writable(dirname(__FILE__)."/data/free")){
			umask(0);
			chmod(dirname(__FILE__)."/data/free",0755);
			if(is_dir(dirname(__FILE__)."/data/free/emoticon"==false)){
			mkdir(dirname(__FILE__)."/data/free/emoticon",0755);
		}
		if(is_dir(dirname(__FILE__)."/data/free/tpl"==false)){
			mkdir(dirname(__FILE__)."/data/free/tpl",0755);
		}
	}
}

/* 어드민 테이블 초기 설정 */
$admin_notice = array('head'=>'','foot'=>'');
$admin_tag = "img,embed,object,b,param,strike";
$admin_spam =  array('ip'=> '','op'=>'ban','word'=>'aloha,viagra');
$admin_insert_string ="INSERT INTO `chibi_admin` (
`cid`, `skin`, `passwd`, `permission`, `title`, `notice`, `tag`, `spam`, `op`) VALUES ('free', 'CB_default', MD5('1234'), '', 'Chibi Tool BBS', '".mysql_real_escape_string(serialize($admin_notice))."', '".mysql_real_escape_string($admin_tag)."', '".mysql_real_escape_string(serialize($admin_spam))."', '".mysql_real_escape_string(serialize($admin_option))."');";

/* admin 테이블 생성 */
if($db_check->status == true && $db_check->admin == false ){
	mysql_query($admin_string,$chibi_conn);
	$admin_error = mysql_error();
	if(empty($admin_error)==true){
		mysql_query($admin_insert_string,$chibi_conn);
		$admin_insert_error = mysql_error();
	}
}

/* 스킨 초기 설정 */
$cid = 'free';
include_once "skin/CB_default/skin.sql.php";
/* skin 테이블 생성 */
if($db_check->status == true && $db_check->skin == false ){
	mysql_query($skin_string,$chibi_conn);
	$skin_error = mysql_error();
	if(empty($skin_error)==true){
		mysql_query($skin_insert_string,$chibi_conn);
		$skin_insert_error = mysql_error();
	}
}
/* 템플릿 초기 설정 */
include "lib/bbs.fn.php";
$tpl = fopen(dirname(__FILE__)."/skin/CB_default/layout.php", "r");
$tpl_file = '';
while (!feof($tpl)){
$tpl_file = $tpl_file.fgets($tpl);
}
$fp=fopen(dirname(__FILE__)."/data/free/tpl/free.tpl.php","w");
fwrite($fp,$tpl_file);
fclose($fp);
fclose($tpl);
chmod(dirname(__FILE__)."/data/free/tpl/free.tpl.php",0644);
$content = convert($tpl_file);
$fp=fopen(dirname(__FILE__)."/data/".$cid."/tpl/".$cid.".tpl.compiled.php","w");
fwrite($fp,$content);
fclose($fp);
chmod(dirname(__FILE__)."/data/".$cid."/tpl/".$cid.".tpl.compiled.php",0644);

/* tpl 테이블 생성 */
if($db_check->status == true && $db_check->tpl == false ){
	mysql_query($tpl_string,$chibi_conn);
	$tpl_error = mysql_error();
/*	if(empty($tpl_error)==true){
		mysql_query($tpl_insert_string,$chibi_conn);
		$tpl_insert_error = mysql_error();
	}*/
}

/* 멤버 초기 설정 */
$profile = array(
	'img1'=>'',
	'img2'=>'',
	'img3'=>'',
	'text'=>''
);
$member_op = array(
	'op1'=>'',
	'op2'=>''
);
$profile = serialize($profile);
$member_op = serialize($member_op);
$member_insert_string = "INSERT INTO `chibi_member` (`mno`, `user_id`, `nickname`, `passwd`, `permission`, `profile`, `point`, `pic`, `comment`, `op`, `lastlogin`, `session` ) VALUES ('1', '".mysql_real_escape_string($admin_id)."', '".mysql_real_escape_string($nickname)."','".mysql_real_escape_string(md5($admin_pass))."','super','".mysql_real_escape_string($profile)."','0','0','0','".mysql_real_escape_string($member_op)."','0','".mysql_real_escape_string(session_id())."')";
/* member 테이블 생성 */
if($db_check->status == true && $db_check->member == false ){
	mysql_query($member_string,$chibi_conn);
	$member_error = mysql_error();
	if(empty($member_error)==true){
		mysql_query($member_insert_string,$chibi_conn);
		$member_insert_error = mysql_error();
	}
}

/* log 테이블 생성*/
if($db_check->status == true && $db_check->log == false ){
	mysql_query($log_string,$chibi_conn);
	$log_error = mysql_error();
}

/* pic 테이블 생성*/
if($db_check->status == true && $db_check->pic == false ){
	mysql_query($pic_string,$chibi_conn);
	$pic_error = mysql_error();
}

/* pic 테이블 생성*/
if($db_check->status == true && $db_check->comment == false ){
	mysql_query($comment_string,$chibi_conn);
	$comment_error = mysql_error();
}


/* emoticon 테이블 생성 */
if($db_check->status == true && $db_check->emoticon == false ){
	mysql_query($emoticon_string,$chibi_conn);
	$emoticon_error = mysql_error();
}
}
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
/* 
게시판이 이미 설치 되어 있을 경우
*/
if(($db_check->admin && $db_check->skin && $db_check->pic && $db_check->comment && $db_check->tpl && $db_check->member && $db_check->emoticon) == true){
?>
<div id="installed" class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
치비BBS 게시판이 이미 설치되어 있습니다.<br/><br/>
<a class="btn btn-danger" href="./install.setup.php">돌아가기</a>
</div>
<?php
exit();
}else if($db_check->status == false){/* DB 정보가 틀렸을 경우 */
?>
<div id="installed" class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
DB 정보가 틀립니다. 호스팅업체에서 다시 확인하시기 바랍니다.<br/><br/>
<a class="btn btn-danger" href="./install.setup.php">돌아가기</a>
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
<table class="table table-bordered">
	<caption>치비 BBS 설치 상태</caption>
	<thead>
		<tr >
			<th class="info">DB 테이블 명</th>
			<th class="info">상태</th>
			<th class="info">상세</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>chibi_admin(게시판)</td>
			<td>
			<?php
			if($db_check->admin==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->admin==false && empty($admin_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$admin_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_skin(스킨)</td>
			<td>
			<?php
			if($db_check->skin==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->skin==false && empty($skin_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$skin_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_pic(그림)</td>
			<td>
			<?php
			if($db_check->pic==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->pic==false && empty($pic_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$pic_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_comment(코멘트)</td>
			<td>
			<?php
			if($db_check->comment==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->comment==false && empty($comment_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$comment_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_member(멤버)</td>
			<td>
			<?php
			if($db_check->member==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->member==false && empty($member_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$member_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_log(로그)</td>
			<td>
			<?php
			if($db_check->log==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->log==false && empty($log_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$log_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_tpl(템플릿)</td>
			<td>
			<?php
			if($db_check->tpl==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->tpl==false && empty($tpl_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$tpl_error."</p>";?></td>
		</tr>
		<tr>
			<td>chibi_emoticon(이모티콘)</td>
			<td>
			<?php
			if($db_check->emoticon==true) echo "<p class=\"text-info\">이미 존재 함</p>";
			else if($db_check->emoticon==false && empty($emoticon_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
			else echo "<p class=\"text-error\">오류(상세참고)</p>"
			?>
			</td>
			<td><?php echo "<p class=\"text-error\">".$emoticon_error."</p>";?></td>
		</tr>
		<tr>
			<td colspan="3">
			<?php if((empty($admin_error) && empty($skin_error) && empty($pic_error) && empty($comment_error) && empty($member_error) && empty($tpl_error) && empty($log_error))==true){
				echo "<a class=\"btn btn-primary\" href=\"admin/admin.php\">설치완료</a>";
			}else{
				echo "<a class=\"btn btn-primary\" href=\"install.setup.php\">돌아가기</a><span class=\"help-block\">오류 항목이 있습니다. 오류 항목을 확인하세요.</span>";	
			}?>
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