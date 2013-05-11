<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());

if(is_file("../data/config/db.config.php")==false){
	echo "<script type=\"text/javascript\">location.href=\"../install.setup.php\";</script>";
}
/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";
/* 게시판 기본 함수 로드*/
include_once "../lib/bbs.fn.php";

/* 설치 확인 */
if(setup_check($chibi_conn)==false){
	echo "<script type=\"text/javascript\">location.href=\"../install.setup.php\";</script>";
}


/* $_GET 변수 재 설정 */
if(empty($_GET['cAct'])==false){
	$cAct = $_GET['cAct'];
}
if(empty($_GET['cid'])==false){
	$cid = $_GET['cid'];
}
if(empty($_GET['skin'])==false){
	$skin = $_GET['skin'];
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 관리자 페이지</title>
<style type="text/css">
body{margin:0px;background:#fcfcfc;}
.count{background:#d9edf7;}
.content{background:#ffffff;}
.logo{color:#ffffff !important;}
.margin70{margin-top:50px;}
.margin20{margin-top:20px;}
th{font-size:12px;}
td{font-size:12px;}
.messageDiv{display:none !important;top:30%;position:fixed;}
#board-create input,#board-create select,#board-create textarea{font-size:12px;}
#board-create .td-left{background:#eeeeee;font-size:12px;}
#board-create .td-right{background:#ffffff;font-size:12px;}
</style>
</head>
<body>
<?php
/* 로그인 체크 */
if(login_check($chibi_conn)==false){/* 로그인 상태가 아닐 때*/
?>
<div class="container margin70">
<div class="alert alert-error margin20">
<a class="close" href="../login.php?mode=admin">&times;</a>
로그인 상태가 아닙니다.<br/>
로그인을 하여주시기 바랍니다.<br/><br/>
<a class="btn btn-danger" href="../login.php?mode=admin">로그인 페이지</a>
</div>
</div>
<?php
}else{
	
	if(empty($member->permission)==true){/* 관리자 권한이 없을 경우*/
?>
<div class="container margin70">
<div class="alert alert-error margin20">
<a class="close" href="javascript:history.go(-1);">&times;</a>
접속권한이 없습니다.<br/>
관리자만 접속 가능한 페이지 입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
</div>
<?php
	}else{/* 관리자 상태로 로그인 하였을 경우*/
?>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container head">
		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		<a href="admin.php" class="brand logo"><strong>Chibi Tool BBS 1.10</strong></a>
			<div class="nav-collapse collapse">
            <ul class="nav">
			<?php 
			if($member->permission=="all" || $member->permission=="super"){
			?>
              <li class="<?php if($cAct=="adminBoardCreate") echo "active";?>">
                <a href="?cAct=adminBoardCreate" >게시판 만들기</a>
              </li>
			  <li class="<?php if($cAct=="adminMemberList") echo "active";?>">
                <a href="?cAct=adminMemberList" >멤버 관리</a>
              </li>
			 <?php
			}
			?>
			  <li class="<?php if($cAct=="adminBoardList"||$cAct=="adminBoardSetup"||$cAct=="adminBoardReset"||$cAct=="adminBoardDelete") echo "active";?>">
                <a href="?cAct=adminBoardList" >게시판 관리</a>
              </li>
			  <li class="<?php if($cAct=="adminBoardStatistics") echo "active";?>">
				<a href="#">통계 보기</a>
                <!--<a href="?cAct=adminBoardStatistics" >통계 보기</a>-->
              </li>
			  <li class="">
                <a href="../logout.php?user_id=<?php echo $member->user_id;?>" >로그아웃</a>
              </li>
			  <?php
				if($member->permission=="super"){
			  ?>
		      <li class="">
                <a href="../admin.php?cAct=Uninstall" >언인스톨</a>
              </li>
			  <?php
			}
			  ?>
            </ul>
          </div>
		</div>
	</div>
</div>
<div class="container margin70">
<div class="row-fluid">
<div class="span12">
<?php
	include_once "admin.setup.php";
	}
}
?>
</div>
</div>
</body>
</html>
