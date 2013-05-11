<?php
header ('Content-type: text/plain');
define("__CHIBI__",time());
$cid = $_GET["cid"];
$user_id = $_GET["user_id"];
include_once "../data/config/db.config.php";
include_once "./db.conn.php";

$input = $HTTP_RAW_POST_DATA;
$spos = strpos($input, "f\r\n");
$inlen = strlen($input);

if($spos === false){
	  exit("정상적인 경로로 접속해 주세요");  //이상한 곳에서 들어온 녀석들..
}else{
  $spos = $spos+3;
  $wtpos = strpos($input, "iWTM")+4;
if($wtpos>16)
{
	$tmpint = substr($input,$wtpos,4);
	$worktime = ord($tmpint[0])*0x1000000 + ord($tmpint[1])*0x10000 + ord($tmpint[2])*0x100 + ord($tmpint[3]);
}

// 이 부분은 JPG일경우의 작업시간 읽기
$wtpos = strpos($input, "bTOL")+8;
if($wtpos>20)
{
	$tmpint = substr($input,$wtpos,4);
	$worktime = ord($tmpint[0])*0x1000000 + ord($tmpint[1])*0x10000 + ord($tmpint[2])*0x100 + ord($tmpint[3]);
}


//if($spos<3)
//{
//	print "Error!\nsize:$inlen\n";
//	exit();
	// 에러로그파일갱신(작업안되어있음;)
//}
else
{
	$passwd = substr($input,0,$spos-3);
	if($passwd=="")$pw = "";
	else $pw = md5($passwd);
	$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$REMOTE_HOST = $_SERVER['REMOTE_HOST'];
	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];


	//-------그림 작성------------
	 $sjp = strpos($input, "JFIF");
	if($sjp === false){
		$file_ext = "png"; 
	}else{
		$file_ext = "jpg";
	}
	$t =microtime();
	$fn = explode(' ',$t);
	$av = ($fn[1]+$fn[0])*100000000;
	$filename = number_format($av,"0","","");
    $uploaddir = '../data/'.$cid.'/';
	$uploadfile = $uploaddir . $filename;
    $success = TRUE;
	$fp = fopen ("$uploadfile.$file_ext","wb");
	$success = $success && fwrite($fp,substr($input, $spos));
    fclose($fp);
	$op = array("secret"=>"","more"=>"");
	$op = serialize($op);
	if ($success) {
		$cnt_sql = "SELECT * FROM `chibi_pic` where `cid`='".$cid."' order by `idx` desc";
		$cnt_query = mysql_query($cnt_sql,$chibi_conn);
		$cnt_array = mysql_fetch_array($cnt_query);
		$cnt = $cnt_array[no]+1;
		//-- mysql db 기록 시작
		$query = "INSERT INTO `chibi_pic` (`idx`,`no`,`cid`, `type`, `src`, `passwd`, `agent`, `pic_ip`, `time`, `op`)VALUES('','".mysql_real_escape_string($cnt)."','".mysql_real_escape_string($cid)."','picture','".mysql_real_escape_string("data/".$cid."/".$filename.".".$file_ext)."','".mysql_real_escape_string($pw)."','".mysql_real_escape_string($_SERVER['HTTP_USER_AGENT'])."','".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."','".time()."','".mysql_real_escape_string($op)."')";
		mysql_query($query,$chibi_conn);
	} 
}
}
?>