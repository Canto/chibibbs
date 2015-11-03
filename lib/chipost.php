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

$count_sql = "SELECT * FROM `chibi_pic` WHERE `cid`='".mysqli_real_escape_string($chibi_conn, $cid)."' ORDER BY `idx` DESC";
$count_query = mysqli_query($chibi_conn, $count_sql);
$count = mysqli_fetch_array($count_query);
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
		$query = "INSERT INTO `chibi_pic` (`idx`,`no`,`cid`, `type`, `src`, `passwd`, `agent`, `pic_ip`, `time`, `op`)VALUES('','".mysqli_real_escape_string($chibi_conn, $cnt)."','".mysqli_real_escape_string($chibi_conn, $cid)."','picture','".mysqli_real_escape_string($chibi_conn, "data/".$cid."/".$filename.$ext)."','".mysqli_real_escape_string($chibi_conn, $pw)."','".mysqli_real_escape_string($chibi_conn, $_SERVER['HTTP_USER_AGENT'])."','".mysqli_real_escape_string($chibi_conn, $_SERVER["REMOTE_ADDR"])."','".time()."','".mysqli_real_escape_string($chibi_conn, $op)."')";
		mysqli_query($chibi_conn, $query);
		if(empty($user_id)==false){
			$bbs = mysqli_fetch_array(select($cid,$chibi_conn));
			$bbs_op = unserialize($bbs['op']);
			$point = $bbs_op['pic_point'];
			$p_sql = "UPDATE `chibi_member` SET `point` = point+'".mysqli_real_escape_string($chibi_conn, $point)."', `pic`=pic+'1' WHERE `user_id` = '".mysqli_real_escape_string($chibi_conn, $user_id)."'";
			mysqli_query($chibi_conn, $p_sql);
		}
		mysqli_close($chibi_conn);
		echo "CHIBIOK";
	}else {
        echo "CHIBIERROR\n";
	}
}else{
	echo "CHIBIERROR No Data\n";
}
?>