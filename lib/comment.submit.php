<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());
$cid = $_POST['cid'];
$page = $_POST['page'];
$name = $_POST['name'];
$passwd = md5($_POST['passwd']);
$comment = $_POST['comment'];
$memo = $_POST['memo'];
$hpurl = $_POST['hpurl'];
$idx = $_POST['idx'];
$op = $_POST['op'];
$depth = $_POST['depth'];
$no = $_POST['no'];
$children = $_POST['children'];
$pic_no = $_POST['pic_no'];

if(empty($depth)==false){
	$depth++;
}
else{
	$depth = 1;
}
if($no=="0")$no=1;
if($children=="0") $children=1;
if(empty($op)==false){
	if($op['dice']) $op['dice'] = rand(1,6)."+".rand(1,6);
	if($op['cookie']=="cookie"){
	setcookie('nickname',$name,60*60*24*30+time(),"/");
	setcookie('passwd',$passwd,60*60*24*30+time(),"/");
	setcookie('hpurl',$hpurl,60*60*24*30+time(),"/");
	setcookie('position',$op['position'],60*60*24*30+time(),"/");
	setcookie('position2',$op['position2'],60*60*24*30+time(),"/");
	setcookie('cookie',$op['cookie'],60*60*24*30+time(),"/");
	}else{
	setcookie('nickname','',60*60*24*30+time(),"/");
	setcookie('passwd','',60*60*24*30+time(),"/");
	setcookie('hpurl','',60*60*24*30+time(),"/");
	setcookie('position','',60*60*24*30+time(),"/");
	setcookie('position2','',60*60*24*30+time(),"/");
	setcookie('cookie','',60*60*24*30+time(),"/");
	}
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
login_check($chibi_conn);
if($member->mno) $passwd = $member->passwd;

if($name && $passwd && $comment && $no && $pic_no){
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
	if(login_check($chibi_conn)==true){
		$bbs = mysqli_fetch_array(select($cid,$chibi_conn));
		$bbs_op = unserialize($bbs['op']);
		$point = $bbs_op['comment_point'];
		$p_sql = "UPDATE `chibi_member` SET `point` = point+'".mysqli_real_escape_string($chibi_conn, $point)."', `comment`=comment+'1' WHERE `user_id` = '".mysqli_real_escape_string($chibi_conn, $member->user_id)."'";
		mysqli_query($chibi_conn, $p_sql);
	}
	if($depth==1){
		$old_sql = "SELECT `chibi_comment`.`no` FROM `chibi_comment` WHERE cid='".mysqli_real_escape_string($chibi_conn, $cid)."' AND `pic_no`='".mysqli_real_escape_string($chibi_conn, $pic_no)."' ORDER BY `no` DESC LIMIT 0,1";
		$old_query = mysqli_query($chibi_conn, $old_sql);
		$old = mysqli_fetch_array($old_query);
		$no = $old['no']+1;
	}
	$chk_sql = "SELECT min(`chibi_comment`.`children`) FROM `chibi_comment` WHERE cid='".mysqli_real_escape_string($chibi_conn, $cid)."' AND `pic_no`='".mysqli_real_escape_string($chibi_conn, $pic_no)."' AND `no`='".mysqli_real_escape_string($chibi_conn, $no)."' AND `children`='".mysqli_real_escape_string($chibi_conn, $children)."' ";
	$chk_query = mysqli_query($chibi_conn, $chk_sql);
	$chk = mysqli_fetch_row($chk_query);
	if($chk[0]!=0){
		//echo "1";
		$upchildren = "UPDATE `chibi_comment` SET `children` = children+'1' WHERE cid='".mysqli_real_escape_string($chibi_conn, $cid)."' AND `pic_no`='".mysqli_real_escape_string($chibi_conn, $pic_no)."' AND `no`='".mysqli_real_escape_string($chibi_conn, $no)."' AND `children`>'".mysqli_real_escape_string($chibi_conn, $children)."'";
		mysqli_query($chibi_conn, $upchildren);
		$children = $chk[0]+1;
	}else{
		//echo "2";
		$old2_sql = "SELECT count(`chibi_comment`.`children`) FROM `chibi_comment` WHERE cid='".mysqli_real_escape_string($chibi_conn, $cid)."' AND `pic_no`='".mysqli_real_escape_string($chibi_conn, $pic_no)."' AND `no`='".mysqli_real_escape_string($chibi_conn, $no)."'";
		$old2_query = mysqli_query($chibi_conn, $old2_sql);
		$old2 = @mysqli_fetch_row($old2_query);
		$children = $old2[0]+1;
	}
	echo "<br/>".$children;
	  $query = "INSERT INTO `chibi_comment` (`idx`,`cid`,`pic_no`,`no`,`children`,`depth`, `name`, `passwd`, `rtime`, `comment`, `memo`, `hpurl`, `ip`, `op`)VALUES('','".mysqli_real_escape_string($chibi_conn, $cid)."','".mysqli_real_escape_string($chibi_conn, $pic_no)."','".mysqli_real_escape_string($chibi_conn, $no)."','".mysqli_real_escape_string($chibi_conn, $children)."','".mysqli_real_escape_string($chibi_conn, $depth)."','".mysqli_real_escape_string($chibi_conn, $name)."','".mysqli_real_escape_string($chibi_conn, $passwd)."','".time()."','".mysqli_real_escape_string($chibi_conn, $comment)."','".mysqli_real_escape_string($chibi_conn, $memo)."','".mysqli_real_escape_string($chibi_conn, $hpurl)."','".$_SERVER["REMOTE_ADDR"]."','".mysqli_real_escape_string($chibi_conn, $op)."')";
	  mysqli_query($chibi_conn, $query);
		echo "<script>alert('등록 완료!!');
	location.href = '../index.php?cid=".$cid."&page=".$page."';
	</script>";
}
}else{
	echo "<script>alert('등록 실패!!');
	history.go(-1);
	</script>";
}

mysqli_close($chibi_conn);
?>