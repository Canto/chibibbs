<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_POST['cid'];
$page = $_POST['page'];
$name = $_POST['name'];
$passwd = $_POST['passwd'];
$comment = $_POST['comment'];
$memo = $_POST['memo'];
$hpurl = $_POST['hpurl'];
$idx = $_POST['idx'];
if(empty($_POST['op'])==false){
	$op = $_POST['op'];
	$op = serialize($op);
}
else{
	$op = '';
}

/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "./db.conn.php";
include_once "./bbs.fn.php";
$bbs_query = select($cid,$chibi_conn);
$bbs = mysqli_fetch_array($bbs_query);
$spamword = unserialize($bbs['spam']);
//echo $spam['word'];
if($name && $passwd && $comment && $idx){
$cf_filter = explode(",", $spamword['word']); 
foreach ($cf_filter as $filter) { 
    $filter = trim($filter); 
    if (strstr($comment, $filter)) 
        $spam = $filter;
}
if(empty($spam)==false){
	echo "<script>alert('".$spam." 은(는) 사용 금지된 단어입니다.');
	history.go(-1);
	</script>";
	exit;

}else{
		$passsql = "SELECT `passwd` FROM `chibi_comment` WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."'";
		$pass = mysqli_query($chibi_conn, $passsql);
		$pass = mysqli_fetch_row($pass);
		if($pass[0]!=md5($passwd)){
		echo "<script>alert('비밀번호가 틀렸습니다.');
		history.go(-1);
		</script>";
		}else{
		$sql = "UPDATE `chibi_comment` SET `hpurl`='".mysqli_real_escape_string($chibi_conn, $hpurl)."' ,`memo`='".mysqli_real_escape_string($chibi_conn, $memo)."' , `name`='".mysqli_real_escape_string($chibi_conn, $name)."' , `comment`='".mysqli_real_escape_string($chibi_conn, $comment)."' , `op`='".mysqli_real_escape_string($chibi_conn, $op)."' WHERE `idx`='".mysqli_real_escape_string($chibi_conn, $idx)."' AND `passwd`='".mysqli_real_escape_string($chibi_conn, md5($passwd))."'";
		mysqli_query($chibi_conn, $sql);
			echo "<script>alert('수정 완료!!');
	location.href = '../index.php?cid=".$cid."&page=".$page."';
	</script>";
}	
}
}
mysqli_close($chibi_conn);
?>

