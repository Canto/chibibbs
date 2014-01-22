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
$passwd = $_POST['passwd'];
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
$bbs = mysql_fetch_array($bbs_query);
$spamword = unserialize($bbs['spam']);
//echo $spam['word'];

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
		$bbs = mysql_fetch_array(select($cid,$chibi_conn));
		$bbs_op = unserialize($bbs['op']);
		$point = $bbs_op['comment_point'];
		$p_sql = "UPDATE `chibi_member` SET `point` = point+'".mysql_real_escape_string($point)."', `comment`=comment+'1' WHERE `user_id` = '".mysql_real_escape_string($member->user_id)."'";
		mysql_query($p_sql,$chibi_conn);
	}
	if($depth==1){
		$old_sql = "SELECT `chibi_comment`.`no` FROM `chibi_comment` WHERE cid='".mysql_real_escape_string($cid)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' ORDER BY `no` DESC LIMIT 0,1";
		$old_query = mysql_query($old_sql,$chibi_conn);
		$old = mysql_fetch_array($old_query);
		$no = $old['no']+1;
	}
	$chk_sql = "SELECT min(`chibi_comment`.`children`) FROM `chibi_comment` WHERE cid='".mysql_real_escape_string($cid)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' AND `no`='".mysql_real_escape_string($no)."' AND `children`='".mysql_real_escape_string($children)."' ";
	$chk_query = mysql_query($chk_sql,$chibi_conn);
	$chk = mysql_fetch_row($chk_query);
	if($chk[0]!=0){
		echo "1";
		$upchildren = "UPDATE `chibi_comment` SET `children` = children+'1' WHERE cid='".mysql_real_escape_string($cid)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' AND `no`='".mysql_real_escape_string($no)."' AND `children`>'".mysql_real_escape_string($children)."'";
		mysql_query($upchildren,$chibi_conn);
		$children = $chk[0]+1;
	}else{
		echo "2";
		$old2_sql = "SELECT count(`chibi_comment`.`children`) FROM `chibi_comment` WHERE cid='".mysql_real_escape_string($cid)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' AND `no`='".mysql_real_escape_string($no)."'";
		$old2_query = mysql_query($old2_sql,$chibi_conn);
		$old2 = @mysql_fetch_row($old2_query);
		$children = $old2[0]+1;
	}
	echo "<br/>".$children;
	  $query = "INSERT INTO `chibi_comment` (`idx`,`cid`,`pic_no`,`no`,`children`,`depth`, `name`, `passwd`, `rtime`, `comment`, `memo`, `hpurl`, `ip`, `op`)VALUES('','".mysql_real_escape_string($cid)."','".mysql_real_escape_string($pic_no)."','".mysql_real_escape_string($no)."','".mysql_real_escape_string($children)."','".mysql_real_escape_string($depth)."','".mysql_real_escape_string($name)."','".mysql_real_escape_string(md5($passwd))."','".time()."','".mysql_real_escape_string($comment)."','".mysql_real_escape_string($memo)."','".mysql_real_escape_string($hpurl)."','".$_SERVER["REMOTE_ADDR"]."','".mysql_real_escape_string($op)."')";
	  mysql_query($query,$chibi_conn);	  
		echo "<script>alert('등록 완료!!');
	location.href = '../index.php?cid=".$cid."&page=".$page."';
	</script>";
}
}else{
	echo "<script>alert('등록 실패!!');
	history.go(-1);
	</script>";
}

mysql_close($chibi_conn);
?>