<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());

if(is_file("data/config/db.config.php")==false){
	echo "<script type=\"text/javascript\">location.href=\"install.setup.php\";</script>";
}
/* DB정보취득 */
include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
/* 게시판 기본 함수 로드*/
include_once "lib/bbs.fn.php";
include_once "lib/bbs.page.php";

/* 설치 확인 */
if(setup_check($chibi_conn)==false){
	echo "<script type=\"text/javascript\">location.href=\"install.setup.php\";</script>";
}
if(!isset($_GET['cid']) || empty($_GET['cid'])){ /* $cid 가 없을때 */
echo "<script language=\"javascript\">alert(\"게시판 ID 를 적어주세요. index.php?cid=게시판ID\");</script>";
exit;
}
$search = '';
$keyword = '';
$cAct = '';
$page = '';
if(empty($_GET['page'])==true){
	$_GET['page'] = 1;
}
/* $_GET 변수 재 설정 */
if(empty($_GET['cAct'])==false){
	$cAct = $_GET['cAct'];
}
if(empty($_GET['search'])==false){
	$search = $_GET['search'];
}
if(empty($_GET['keyword'])==false){
	$keyword = $_GET['keyword'];
}
if(empty($_GET['cAct'])==false){
	$cAct = $_GET['cAct'];
}
if(empty($_GET['cid'])==false){
	$cid = $_GET['cid'];
	$page = $_GET['page'];
	/* $cid 가 존재할 경우 게시판 정보 셋팅 */
	$bbs_query = select($cid,$chibi_conn);
	$bbs = (object) mysqli_fetch_array($bbs_query);
	$bbs->spam = (object) unserialize($bbs->spam);
	$bbs->notice = (object) unserialize($bbs->notice);
	$bbs->op = (object) unserialize($bbs->op);
	
	/* $cid 가 존재할 경우 스킨 정보 셋팅 */
	$skin_query = select_skin($cid,$chibi_conn);
	$skin = (object) mysqli_fetch_array($skin_query);
	$skin->op = (object) unserialize($skin->op);

	/* 유저 함수파일이 있으면 인클루드 */
	if(file_exists("skin/".$bbs->skin."/user.fn.php")) include_once 'skin/'.$bbs->skin.'/user.fn.php';
	
	/* IP 체크 */
	if($bbs->spam->op == "ban"){
		ip_check($bbs->spam->ip); /* IP 체크 함수*/
	}
	
	/*비공개 게시판 접속 권한 획득*/
	if(isset($_SESSION['session_key_cookie'])){
		if($_SESSION['session_key_cookie']==md5($cid.'+'.session_id())){
		$connect_permission = true;
		}else{
		$connect_permission = false;
		}
	}else{
		$connect_permission = false;
	}

	
	if(!isset($cid) || empty($bbs->cid)==true){ /* 존재 하지 않는 게시판일 경우*/
	echo "<script language=\"javascript\">alert(\"존재하지 않는 게시판 입니다.\");</script>";
	exit;
	}


/*   페이징 설정   */
	switch($search){
		case "name" :
			$sql = "SELECT count(`chibi_pic`.`idx`) FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`name`LIKE'".mysqli_real_escape_string($chibi_conn, $keyword)."' AND  `chibi_comment`.`cid`='".mysqli_real_escape_string($chibi_conn, $cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC ";
			break;
		case "comment" :
			$sql = "SELECT count(`chibi_pic`.`idx`) FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`comment` LIKE '%".mysqli_real_escape_string($chibi_conn, $keyword)."%' AND  `chibi_comment`.`cid` =  '".mysqli_real_escape_string($chibi_conn, $cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC";
			break;
		case "memo" :
			$sql = "SELECT count(`chibi_pic`.`idx`) FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`memo` LIKE '%".mysqli_real_escape_string($chibi_conn, $keyword)."%' AND  `chibi_comment`.`cid` =  '".mysqli_real_escape_string($chibi_conn, $cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC";
			break;
		case "no" : 
			$sql = "SELECT count(no) FROM `chibi_pic` WHERE cid='".mysqli_real_escape_string($chibi_conn, $cid)."' AND no='".mysqli_real_escape_string($chibi_conn, $keyword)."'";
			break;
		default :
			$sql = "SELECT count(no) FROM `chibi_pic` WHERE cid='".mysqli_real_escape_string($chibi_conn, $cid)."'";
			break;
	}

	//echo $sql;
	$query = mysqli_query($chibi_conn, $sql);
	$total_row = mysqli_fetch_row($query);
	if($search && $search!="no") $total = mysqli_num_rows($query);
	else $total = $total_row[0];
	$pageBar = new paging($_GET['page'],$bbs->op->pic_page,$bbs->op->pic_page_bar,$total);
	$pageBar->setUrl('cid='.$cid);
	if(empty($search)==false) $pageBar->setUrl('search='.$search);
	if(empty($keyword)==false) $pageBar->setUrl('keyword='.$keyword);
	if($_GET['page']==1) $start = 0;
	else $start = ($_GET['page']-1) * $bbs->op->pic_page;
	$limit = $bbs->op->pic_page;
	$pageBar->setDisplay('prev_btn','<');
	$pageBar->setDisplay('next_btn','>');
	$pageBar->setDisplay('start_btn','<<');
	$pageBar->setDisplay('end_btn','>>');
	$pageBar->setDisplay('full');
	if($total!=0)$paging = $pageBar->showPage();
	else $paging ='';
	$member ='';

	if(login_check($chibi_conn)!=false) $permission = bbs_permission($member->permission,$cid);
	else $permission = '';
	
	/* 디바이스체크(PC or MOBILE) */
	$device = device_check();
	/* 카운트(통계) */
	if($member->permission != "super"){
	count_up($cid,$chibi_conn);
	}
	
	/* 게시판 path 취득 */
	$dir = explode("index.php",$_SERVER['PHP_SELF']);
	$path = "http://".$_SERVER['SERVER_NAME'].$dir[0];
	
include "skin/".$bbs->skin."/index.layout.php";
}
?>
