<?php
if(!defined("__CHIBI__")) exit();


$today = date("Ymd");
$device = device_check();


if(empty($cAct)==true || $cAct=="adminBoardList"){

/* 게시판 관리자일 경우 카운트 설정 */
if($member->permission!="all" || $member->permission!="super"){
$count_sql = explode(",",$member->permission);
$i = 0;
while($i<count($count_sql)){
	if($i==0) $count_log = "`cid`='".mysqli_real_escape_string($chibi_conn, $count_sql[$i])."'";
	else $count_log = $count_log." OR `cid`='".mysqli_real_escape_string($chibi_conn, $count_sql[$i])."'";
	$i++;
}
$count_log_today = "(".$count_log.") AND date LIKE '".mysqli_real_escape_string($chibi_conn, $today)."%'";
}
?>
<div class="container">
<div class="span10 offset1 ">
<table class="table table-bordered">
<tbody>
<tr>
<td class="count span2">
<p>총 방문자 수</p>
</td>
<td class="content">
<p>
<?php 
if($member->permission == "all" || $member->permission == "super") echo count_bbs("log","",$chibi_conn);
else echo count_bbs("log",$count_log,$chibi_conn);
?>
</p>
</td>
<?php 
if ($device=="mobile"){
}else{
	?>
<td rowspan="4" class="content span8" style="padding: 0px;height:100%;">
<iframe src ="http://chibi.kr/update2.php?ver=<?=$chibi_ver?>" width="100%" height="100%" scrolling="auto" frameborder="0" style="border:0;"></iframe>
</td>
<?php
}
	?>
</tr>
<tr>
<td class="count span2">
<p>오늘 방문자 수</p>
</td>
<td class="content">
<p>
<?php 
if($member->permission == "all" || $member->permission=="super") echo count_bbs("log","date LIKE '".mysqli_real_escape_string($chibi_conn, $today)."%'",$chibi_conn);
else echo count_bbs("log",$count_log_today,$chibi_conn);
?>
</p>
</td>
</tr>
<tr>
<td class="count span2">
<p>총 그림 수</p> 
</td>
<td class="content">
<p>
<?php 
if($member->permission == "all" || $member->permission=="super") echo count_bbs("pic","",$chibi_conn);
else echo count_bbs("pic",$count_log,$chibi_conn);
?>
</p>
</td>
</tr>
<tr>
<td class="count span2">
<p>총 코멘트 수</p> 
</td>
<td class="content">
<p>
<?php 
if($member->permission == "all" || $member->permission=="super") echo count_bbs("comment","",$chibi_conn);
else echo count_bbs("comment",$count_log,$chibi_conn);
?>
</p>
</td>
</tr>
</tbody>
</table>
</div>
<?php
}
?>
</div>
<div class="container">
<?php 
if(empty($cAct)==true){
	?>
<style>
#lightbox {
			position:absolute; /* keeps the lightbox window in the current viewport */
			top:0; 
			left:0; 
			min-width:100%; 
			text-align:center;
		}
		#lightbox p {
			color:#fff; 
			margin-right:20px; 
			font-size:12px; 
		}
		#content{

		}
		#lightbox img {
			padding:20px;
			background:#666666;;
			box-shadow:0 0 25px #111;
			-webkit-box-shadow:0 0 25px #111;
			-moz-box-shadow:0 0 25px #111;
			max-width:100%;
		}
a.thumbnail {margin:0;margin-bottom:5px;}
.news{margin:10px !important;}
</style>
<script>
jQuery(document).ready(function($) {
	$('.lightbox_trigger').click(function(e) {
		e.preventDefault();
		var image_href = $(this).attr("href");
		var scrolltop = $(window).scrollTop()+50;
		if ($('#lightbox').length > 0) { 
			$('#lightbox').css('top',scrolltop);	
			$('#content').html('<a href="javascript:close();"><img src="' + image_href +'" /></a>');
			$('#lightbox').show();
		}
		else { 
			var lightbox = 
			'<div id="lightbox">' +
				'<div id="content">' + 
					'<a href="javascript:close();"><img src="' + image_href +'" /></a>' +
				'</div>' +	
			'</div>';
			$('body').append(lightbox);
			$('#lightbox').css('top',scrolltop);
		}
	});
});
function close() { 
		$('#lightbox').hide();
	}
</script>
<?php 
if($member->permission == "all" || $member->permission=="super"){
$chk_update_sql = "SHOW FIELDS FROM  `chibi_comment` WHERE  `field` =  'children'";
$chk_update_query = mysqli_query($chibi_conn, $chk_update_sql);
$chk_update = mysqli_fetch_row($chk_update_query);
if($chk_update[0]==NULL){
?>
<script>
function update(){
	$.ajax({
		   url: './update/1.10.4.php',
		   dataType: 'html',
		   success: function(data){
			   if(data == true){
					alert("업데이트 완료!!");
					location.href="./admin.php?cid=<?=$cid?>";
			   }else{
			    alert("업데이트 실패");
			   }
		   }
		  });
}
</script>
<div class="alert" style="margin:10px auto;width:70%;">
Comment 모듈에 업데이트가 존재합니다. <a href="javascript:update();">모듈 업데이트</a>
</div>
<?php 
}
}
?>
<div class="span12 well">
<p class="text-info"><strong>최근 등록 그림</strong><p>
<ul class="inline" style="text-align:center">
<?php
if($member->permission == "all" || $member->permission =="super") $news_pic_query = news_pic($chibi_conn,"");
else $news_pic_query = news_pic($chibi_conn,$count_log);
while($news_pic_array=mysqli_fetch_array($news_pic_query)){
	$news_pic = (object) $news_pic_array;
?>
<li>
<?php echo "<a class=\"thumbnail lightbox_trigger\" href=\"../".$news_pic->src."\"><img src=\"../".$news_pic->src."\" style=\"width:80px;height:80px;\"></a>";?> 
</li>
<?php
}
?>
</ul>
</div>
<div class="span12 well">
<p class="text-info"><strong>최근 등록 코멘트</strong><p>
<ul class="unstyled">
<?php
if($member->permission == "all" || $member->permission =="super") $news_cmt_query = news_comment($chibi_conn,"");
else $news_cmt_query = news_comment($chibi_conn,$count_log);
while($news_cmt_array=mysqli_fetch_array($news_cmt_query)){
	$news_cmt = (object) $news_cmt_array;
?>
<li style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
&raquo;&nbsp;&nbsp;<a href="../index.php?cid=<?=$news_cmt->cid?>&search=name&keyword=<?=$news_cmt->name?>" target="_blank"><?php echo $news_cmt->name; ?></a>&nbsp;-&nbsp;<a href="../index.php?cid=<?=$news_cmt->cid?>&search=no&keyword=<?=$news_cmt->pic_no?>" target="_blank"><?php echo stripslashes($news_cmt->comment);?></a>
</li>
<?php
}
?>
</ul>
</div>
<?php
}else{

		switch($cAct){ /* cAct 에 따른 분기 */
		case "adminBoardCreate" : /* 게시판 생성 */
			include_once "admin.board.create.php";
			break;
		case "adminBoardCreateOk" : /* 게시판 생성완료 */
			include_once "admin.board.create.ok.php";
			break;
		case "adminBoardList" : /* 게시판 리스트 */
			include_once "admin.board.list.php";
			break;
		case "adminBoardSetup" : /* 게시판 수정 */
			include_once "admin.board.setup.php";
			break;
		case "adminBoardSetupOk" : /* 게시판 수정 완료*/
			include_once "admin.board.setup.ok.php";
			break;
		case "adminBoardReset" : /* 게시판 리셋 */
			include_once "admin.board.reset.php";
			break;
		case "adminBoardDelete" : /* 게시판 삭제 */
			include_once "admin.board.delete.php";
			break;
		case "adminSkinSetup" : /* 스킨 수정 */
			include_once "../skin/".$skin."/admin.board.skin.php";
			break;
		case "adminSkinTpl" : /* 템플릿 수정 */
			include_once "admin.board.skin.tpl.php";
			break;
		case "adminSkinTplOk" : /* 템플릿 수정 완료 */
			include_once "admin.board.skin.tpl.ok.php";
			break;
		case "adminSkinSetupOk" : /* 스킨 수정 */
			include_once "admin.board.skin.ok.php";
			break;
		case "adminEmoticonSetup" : /* 이모티콘 설정 */
			include_once "admin.board.emoticon.php";
			break;
		case "adminMemberList" : /* 맴버 리스트 */
			include_once "admin.member.list.php";
			break;
		case "adminMemberSetup" : /* 멤버 정보 수정 */
			include_once "admin.member.setup.php";
			break;
		case "adminMemberSetupOk" : /* 멤버 정보 수정 */
			include_once "admin.member.setup.ok.php";
			break;
		case "adminMemberAdd" : /* 맴버 추가 */
			include_once "admin.member.add.php";
			break;
		case "adminMemberAddOk" : /* 맴버 추가 완료*/
			include_once "admin.member.add.ok.php";
			break;
		case "adminMemberDelete" : /* 맴버 삭제 */
			include_once "admin.member.delete.php";
			break;
		case "uninstall" : /* 언인스톨 */
			include_once "admin.uninstall.php";
			break;
		default :
			echo "<div class=\"span6 offset3 alert alert-error\">
					올바른 경로로 접속하여 주세요.<br/>
				</div>";
			break;
		}
	}
?>
</div>
</div>
