<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
if(empty($_GET['user_id'])==false){
	$user_id = $_GET['user_id'];
}else{
	$user_id = '';
}
$passwd = $_GET["passwd"];
$cid = $_GET["cid"];

/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";

if($passwd=="")$pw = "";
else $pw = md5($passwd);

$op = array("secret"=>"","more"=>"","user_id"=>$user_id);
$op = serialize($op);

$count_sql = "SELECT * FROM `chibi_pic` WHERE `cid`='".mysql_real_escape_string($cid)."' ORDER BY `idx` DESC";
$count_query = mysql_query($count_sql,$chibi_conn);
$count = mysql_fetch_array($count_query);
$cnt = $count[no]+1;

//-------그림 작성------------//
if (isset($_FILES["picture"])){
	$t =microtime();
	$fn = explode(' ',$t);
	$av = ($fn[1]+$fn[0])*100000000;
	$filename = number_format($av,"0","","");
	$uploaddir = '../data/'.$cid.'/';
	$file = $_FILES['picture']['name'];
	$ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));
	$uploadfile = $uploaddir.$filename;
	if (isset($_FILES["picture"])&&$ext == ".png"){
		if($_FILES['chibifile']['tmp_name']) move_uploaded_file($_FILES['chibifile']['tmp_name'], $uploadfile.".chi");
        if($_FILES['picture']['tmp_name']) move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile.$ext);
		//-- mysql db 기록 시작
		$query = "INSERT INTO `chibi_pic` (`idx`,`no`,`cid`, `type`, `src`, `passwd`, `agent`, `pic_ip`, `time`, `op`)VALUES('','".mysql_real_escape_string($cnt)."','".mysql_real_escape_string($cid)."','picture','".mysql_real_escape_string("data/".$cid."/".$filename.$ext)."','".mysql_real_escape_string($pw)."','".mysql_real_escape_string($_SERVER['HTTP_USER_AGENT'])."','".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."','".time()."','".mysql_real_escape_string($op)."')";
		mysql_query($query,$chibi_conn);
		if(empty($user_id)==false){
			$bbs = mysql_fetch_array(select($cid,$chibi_conn));
			$bbs_op = unserialize($bbs['op']);
			$point = $bbs_op['pic_point'];
			$p_sql = "UPDATE `chibi_member` SET `point` = point+'".mysql_real_escape_string($point)."', `pic`=pic+'1' WHERE `user_id` = '".mysql_real_escape_string($user_id)."'";
			mysql_query($p_sql,$chibi_conn);
		}
		mysql_close($chibi_conn);
		echo "CHIBIOK";
	}else {
        echo "CHIBIERROR\n";
	}
}else{
	echo "CHIBIERROR No Data\n";
}
?>