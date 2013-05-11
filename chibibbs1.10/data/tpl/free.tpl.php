<!--// 스킨 디자인 시작 //-->

<!--// 상단 공지사항 시작 //-->
<?php if($bbs->notice->head){?>
<div class="span8 offset2">
<div class="alert alert-info user_notice_border_color user_notice_border_type user_notice_background_color">
	<?php echo $bbs->notice->head;?>
</div>
</div>
<?}?>
<!--// 상단 공지사항 끝 //-->


<!-- // 페이지바 시작 //-->
<div class="span8 offset2 pagination text-center">
  <ul>
	<?php echo $paging;?>
  </ul>
</div>
<!-- // 페이지바 끝 //-->


<!--// 툴바 시작 //-->
<div class="span8 offset2 text-center">
<p>
<form id="drawForm" method="POST" class="form-inline" action="./index.php?cid=<?=$cid?>&cAct=picDraw">
<input id="tool" type="hidden" name="tool" value="">
<input id="chi_file" type="hidden" name="chi_file" value="">
<span>너비</span> <input type="text" class="span2" id="width" name="width" placeholder="<?=$bbs->op->pic_min_width?>-<?=$bbs->op->pic_max_width?>">
<span>높이</span> <input type="text" class="span2" id="height" name="height" placeholder="<?=$bbs->op->pic_min_width?>-<?=$bbs->op->pic_max_width?>">
<?php if($device=="mobile") echo "<p class=\"marginTop5\">";?>
<a onclick="selectTool('btool')" <?php if($bbs->op->btool=='off') echo "style=\"display:none;\"";?>><?=$skin->op->btool_icon?></a>
<a onclick="selectTool('chibi')"><?=$skin->op->chibi_icon?></a>
<a id="openLoad" href="javascript:;"><?=$skin->op->load_icon?></a>
<?php if($device=="mobile") echo "</p>";?>
</form>
</p>
</div>
<!--// 툴바 종료 //-->


<!--// 로드 폼 시작 //-->
<div id="loadForm" class="text-center alert alert-info span4 offset4">
<ul class="unstyled">
<li>
<select id="loadSelect">
<option selected="selected">로드 방식</option>
<option value="picture">그림</option>
<option value="youtube">유튜브</option>
<option value="naver">네이버동영상</option>
</select>
</li>
<li>
<div class=".div"></div>
<div class="loadpic">
<form class="form-horizontal" id="uploadForm" action="lib/load.submit.php" onsubmit="return upload()" method="post" enctype="multipart/form-data">
<input name="image" class="input-large" id="inputFile" type="file" required>
<input type="password" name="passwd" class="span5" placeholder="패스워드" required>
<button type="submit" id="uploadBtn" class="btn btn-primary">로드</button>
<input type="hidden" id="type" class="type" name="type">
<input type="hidden" id="cid" name="cid" value="<?=$cid?>">
</form>
</div>
<div class="video">
<form class="form-horizontal" id="uploadVForm" action="lib/load.submit.php" onsubmit="return uploadV()" method="post" enctype="multipart/form-data">
<textarea rows="3" class="span12" id="video" name="image" style="resize:none;" required></textarea>
<input type="password" name="passwd" class="span5" placeholder="패스워드" required>
<button type="submit" id="uploadVBtn" class="marginTop5 btn btn-primary">로드</button>
<input type="hidden" id="type" class="type" name="type">
<input type="hidden" id="cid" name="cid" value="<?=$cid?>">
</form>
</div>
<p class="text-right"><a id="closeLoad" href="javascript:;">닫기</a></p>
</li>
</ul>
<iframe id="uploadIFrame" name="uploadIFrame" src="" style="display:none;visibility:hidden"></iframe>
</div>
<!--// 로드 폼 종료 //-->



<!--// 상단 메뉴 시작 //-->
<div class="span8 offset2 text-center">
<a href="./index.php?cid=<?=$cid?>&page=<?=$_GET['page']?>"><span class="label label-info">새로고침</span></a>
<?php if(empty($permission)==true){?><a href="./login.php?cid=<?=$cid?>"><span class="label label-info">관리자 모드</span></a>
<?php }else if($permission=="true"){ ?>
<a href="./admin/admin.php" target="_blank"><span class="label label-info">게시판 관리</span></a>
<a href="./logout.php?user_id=<?=$member->user_id?>"><span class="label label-info">로그아웃</span></a>
<?php }else{ ?>
<a href="./logout.php?user_id=<?=$member->user_id?>"><span class="label label-info">로그아웃</span></a>
<?php } ?>
<span class="label label-info">이모티콘</span>
</div>
<!--// 상단 메뉴 종료 //-->

<!--// 관리자 패널 //-->
<?php if(empty($permission)==false && $permission=="true"){ ?>
<?php if($device!="mobile"){ ?>
<div class="text-center adminpanel" >
<p>
<form class="adminCmtDel margin0" method="POST" action="./lib/comment.admin.del.php">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="idx">
<button type="submit" id="admindelbtn" class="btn btn-mini btn-danger" style="">리플<br/>삭제</button>
</form>
<p/>
<p>
<form class="adminPicDel margin0" method="POST" action="./lib/pic.admin.del.php">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="idx">
<button type="submit" id="admindelbtn" class="btn btn-mini btn-danger" style="">그림<br/>삭제</button>
</form>
</p>
</div>
<?}else{?>
<div class="span6 offset3 text-center" >
<form class="adminCmtDel margin0" method="POST" action="./lib/comment.admin.del.php" style="display:inline;">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="idx">
<button type="submit" id="admindelbtn" class="btn btn-mini btn-danger" style="">리플 삭제</button>
</form>
<form class="adminPicDel margin0" method="POST" action="./lib/pic.admin.del.php" style="display:inline;">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="idx">
<button type="submit" id="admindelbtn" class="btn btn-mini btn-danger" style="">그림 삭제</button>
</form>
</div>
<?php } ?>
<?php } ?>
<!--// 관리자 패널 //-->



<?php
/* 그림을 불러오기 위한 반복문 시작 */
$pic_query = pic($cid,$start,$limit,$chibi_conn,$search,$keyword); /* 그림 불러오기 */
while($pic = mysql_fetch_array($pic_query)){ /* 반복문 시작 */
$pic = (object) $pic;  
if(empty($pic->op)==false){
	$pic->op = unserialize($pic->op);
	$pic->op = (object) $pic->op;
}
if($pic->type=="youtube"){
	if(get_magic_quotes_gpc()) $pic->src = stripslashes($pic->src); /* magic_quotes_gpc가 off일경우 slashes설정 */
	preg_match('@src="([^"]+)"@',$pic->src,$src);
	$picture = "<p class=\"movie thumbnail\"><iframe width=\"100%\" height=\"100%\" src=\"".$src[1]."\" frameborder=\"0\" allowfullscreen></iframe></p>";
}else if($pic->type=="naver"){
	if(get_magic_quotes_gpc()) $pic->src = stripslashes($pic->src); /* magic_quotes_gpc가 off일경우 slashes설정 */
	preg_match( '@src="([^"]+)"@' , $pic->src , $src );
	$picture = "<p class=\"movie thumbnail\"><iframe width=\"100%\" height=\"100%\" src=\"".$src[1]."\" frameborder=\"no\" scrolling=\"no\" ></iframe></p>";
}else{
	$size = GetImageSize($pic->src);
	if(($pic->op->pic=="secret" && $pic->pic_ip != $_SERVER['REMOTE_ADDR'])&& empty($permission)==true) $picture = "<p class=\"label\"><i class=\"icon-warning-sign\"></i>SECRET</p>";
	else{
	if($pic->op->pic=="more") $picture = "<a class=\"thumbnail lightbox_trigger user_pic_border_hover user_pic_background_color\" href=\"".$pic->src."\" style=\"display:none;\"><img src=\"".$pic->src."\"></a>";
	else $picture = "<a class=\"thumbnail lightbox_trigger user_pic_border_hover user_pic_background_color\" href=\"".$pic->src."\"><img src=\"".$pic->src."\"></a>";
	if($pic->op->pic=="secret") $picture = "<p class=\"label\"><i class=\"icon-warning-sign\"></i>SECRET</p>".$picture;
	}
}
?>


<!--// 본문 시작 //-->
<div class="container">
<div class="row-fluid margin0">
<div class="span12">
<span class="badge badge-info">&nbsp;&nbsp;<?=$pic->no?>&nbsp;&nbsp;</span>
<!--// 관리자용 체크박스 //-->
<?php if(empty($permission)==false && $permission=="true"){?>
<input style="line-height:20px;" type="checkbox" class="picidx" name="picidx" value="<?=$pic->idx?>" >
<?php } ?>
<!--// 관리자용 체크박스 //-->
</div>
<ul class="thumbnails inline">
<li class="span5 text-center">
<div class="span12 popup">
<?php if($pic->op->pic=="more") echo"<a class=\"span12 label picmore\" more=\"0\" href=\"javascript:;\"><i class=\" icon-chevron-down\"></i>&nbsp;more&nbsp;</a>";?>
<?=$picture;?>
</div>
<p class="text-right">

<?php if($pic->pic_ip==$_SERVER['REMOTE_ADDR']){ ?>
<a href="javascript:;" idx="<?=$pic->idx?>" class="opBtn"><span class="badge badge-info marginTop5">옵션</span></a>
<?php }?>

<?php if($pic->type=="picture"){?>
<a href="javascript:;" idx="<?=$pic->idx?>" class="continueBtn"><span class="badge badge-info marginTop5">이어그리기</span><a/>
<?php } ?>
<a href="javascript:;" idx="<?=$pic->idx?>" class="picdelBtn">
<span class="badge badge-info marginTop5">삭제</span>
</a>
</p>
</li>
<!--// 코멘트 시작 //-->
<li class="well well-small span7 user_table_border_color user_table_border_size user_table_border_type user_reply_background_color">
<ul class="unstyled">

<?php
/* 코멘트를 불러오기 위한 반복문 시작*/
$no = 0;
$cmt_query = comment($cid,$pic->no,$chibi_conn);
while($comment = mysql_fetch_array($cmt_query)){
$comment = (object) $comment;
if(empty($comment->op)==false){
	$comment->op = unserialize($comment->op);
	$comment->op = (object) $comment->op;
}
$no = $comment->no;
if(($comment->op->secret=="secret" && $comment->ip != $_SERVER['REMOTE_ADDR']) && empty($permission)==true ){ $comment->comment = "<p class=\"label\"><i class=\"icon-warning-sign\"></i>SECRET</p>";
}else{
$comment->comment = htmlFilter($comment->comment,1,$bbs->tag);
$comment->name = htmlFilter($comment->name,1,$bbs->tag);
if($keyword) $comment->comment = str_replace($keyword,"<span style='color:#FF001E;background-color:#FFF000;'>".$keyword."</span>",$comment->comment);
$comment->comment = nl2br($comment->comment);
if(get_magic_quotes_gpc()) $comment->comment = stripslashes($comment->comment); 
if($comment->op->secret=="secret") $comment->comment = "<p class=\"label\"><i class=\"icon-warning-sign\"></i>SECRET</p>&nbsp;&nbsp;".$comment->comment;
}
if($comment->op->dice) $dice = explode("+",$comment->op->dice);
else $dice = '';
?>

<li class="user_reply_text_color">

<?php if($comment->depth > 1) for($i=1;$i<$comment->depth;$i++) echo "<blockquote class=\"user_rereply_bar_color user_rereply_text_color\">"; ?>

<ul class="unstyled comment">
<li>
<b><?=$comment->name?></b>
<?php if($pic->pic_ip == $comment->ip) echo "[작가글]";?>
 - 
<?php if(empty($dice)==false) echo "<img src=\"images/".$dice[0]."\"><img src=\"images/".$dice[1]."\">"; ?>
<?=date("Y/m/d(D) H:i:s",$comment->rtime)?> 
<a href="javascript:;" no="<?=$comment->no?>" pic_no="<?=$comment->pic_no?>" depth="<?=$comment->depth?>" class="reply"><?=$skin->op->reply_icon?></a> 
<a href="javascript:;" no="<?=$comment->no?>" idx="<?=$comment->idx?>" pic_no="<?=$comment->pic_no?>" depth="<?=$comment->depth?>" class="modify"><?=$skin->op->modify_icon?></a> 
<a href="javascript:;" no="<?=$comment->no?>" idx="<?=$comment->idx?>" pic_no="<?=$comment->pic_no?>" depth="<?=$comment->depth?>" rtime="<?=$comment->rtime?>" class="delBtn"><?=$skin->op->del_icon?></a>
<!--// 관리자용 체크박스 //-->
<?php if(empty($permission)==false && $permission=="true"){?>
<input style="line-height:20px;" type="checkbox" class="idx" name="idx" value="<?=$comment->idx?>" >
<?php } ?>
<!--// 관리자용 체크박스 //-->
</li>
<li class="comment">
<!--/* 코멘트 출력 시작 */-->
<?php if(empty($comment->op->more)==false) echo"<a class=\"label more\" more=\"0\" href=\"javascript:;\"><i class=\" icon-chevron-down\"></i>&nbsp;more&nbsp;</a><p style=\"display:none;\">";
else "<p>";
?>
<?=$comment->comment?>
</p>
<!--/* 코멘트 출력 종료*/-->
</li>
</ul>

<?php if($comment->depth != 1) for($i=0;$i<$comment->depth;$i++) echo "</blockquote>"; ?>
</li>
<?php
/*코멘트를 불러오기 위한 반복문 종료*/
}
?>
</ul>
<!--// 코멘트 작성 폼 //-->
<div class="text-right">
<form class="form-horizontal margin0 cmtForm" action="#">
<div class="controls">
<textarea rows="2" class="span12" id="comment" name="comment" style="resize:none;" ></textarea>
</div>
<div class="controls">
<p>
<label class="checkbox inline">
<input type="checkbox" id="op['secret']" name="op[secret]" value="secret">secret
</label>
<label class="checkbox inline">
<input type="checkbox" id="op['more']" name="op[more]" value="more">more
</label>
<label class="checkbox inline">
<input type="checkbox" id="op['dice']" name="op[dice]" value="dice">dice
</label>
</p>
</div>
<div class="controls">
<input type="hidden" name="cid" value="<?=$cid?>">
  <input type="hidden" name="no" value="<?=$no?>">
  <input type="hidden" name="pic_no" value="<?=$pic->no?>">
  <input type="text" class="input-mini" name="name" id="name" placeholder="name">
  <input type="password" class="input-mini" name="passwd" id="passwd" placeholder="password">
  <button type="submit" class="cmt-submit btn btn-mini btn-info">write</button>
</div>
</form>
</div>
<!--// 코멘트 작성 종료 //-->
</li>
</ul>
<!--// 코멘트 종료 //-->
</div>
</div>
<!--// 본문 종료 //-->
<?php
} /* 그림 불러오기 위한 반복문 종료 */
?>
<div class="span8 offset2 pagination text-center">
  <ul>
	<?php echo $paging;?>
  </ul>
</div>

<!--// 하단 공지사항 시작 //-->
<?php if($bbs->notice->foot){?>
<div class="span8 offset2">
<div class="alert alert-info user_notice_border_color user_notice_border_type user_notice_background_color">
	<?php echo $bbs->notice->foot;?>
</div>
</div>
<?}?>
<!--// 상단 공지사항 끝 //-->

<!--// 스킨 디자인 종료 //-->



<!--// 리플 폼 시작 //-->
<div id="replyForm" class="text-right">
<p><a href="javascript:;" class="replyClose"><span class="label">리플창 닫기</span></a></p>
<form class="form-horizontal margin0 cmtForm" action="#">
<div class="controls-group">
<textarea rows="2" class="span7" id="comment" name="comment" style="resize:none;" ></textarea>
</div>
<div class="controls-group">
<p>
<label class="checkbox inline">
<input type="checkbox" id="op['secret']" name="op['secret']" value="secret">secret
</label>
<label class="checkbox inline">
<input type="checkbox" id="op['more']" name="op['more']" value="more">more
</label>
<label class="checkbox inline">
<input type="checkbox" id="op['dice']" name="op['dice']" value="dice">dice
</label>
</p>
</div>
<div class="controls-group">
<input type="hidden" name="idx" id="idx" value="">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="cid" value="<?=$cid?>">
  <input type="hidden" id="no" name="no" value="">
  <input type="hidden" id="pic_no" name="pic_no" value="">
    <input type="hidden" id="depth" name="depth" value="">
  <input type="text" class="input-mini" name="name" id="name" placeholder="name">
  <input type="password" class="input-mini" name="passwd" id="passwd" placeholder="password">
  <button type="submit" class="cmt-submit btn btn-mini btn-info">write</button>
</div>
</form>
</div>
<!--// 리플 폼 종료 //-->

<!--// 리플 삭제 폼 //-->
<div id="delForm" class="text-right" style="display:none;">
<form class="cmtdelForm form-inline margin0" method="POST" action="lib/comment.del.php?cid=<?=$cid?>&page=<?=$page?>">
<input type="hidden" id="pic_no" name="pic_no" value="">
<input type="hidden" id="idx" name="idx" value="">
<input type="hidden" id="member" name="member" value="<?=session_id()?>">
<input type="password" class="input-mini" name="passwd" id="passwd" placeholder="passwd">
<button type="submit" class="btn btn-mini btn-danger" >삭제</button> 
<a href="javascript:;" class="delClose btn btn-mini btn-danger">삭제창 닫기</a>
</form>
</div>
<!--// 리플 삭제 폼 //-->

<!--// 그림 삭제 폼 //-->
<div id="delpicForm" class="text-right marginTop5" style="display:none;">
<form class="picdelForm form-inline margin0" action="#">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" id="idx" name="idx" value="">
<input type="password" class="input-mini" name="passwd" id="passwd" placeholder="passwd">
<button type="submit" class="btn btn-mini btn-danger" >삭제</button> 
<a href="javascript:;" class="picdelClose btn btn-mini btn-danger">삭제창 닫기</a>
</form>
</div>
<!--// 그림 삭제 폼 //-->

<!--// 이어 그리기 폼 //-->
<div id="continuepicForm" class="text-right marginTop5" style="display:none;">
<form class="piccontinueForm form-inline margin0" method="POST" action="./index.php?cAct=picContinue&cid=<?=$cid?>">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" id="chi_idx" name="chi_idx" value="">
<input type="password" class="input-mini" name="continue_passwd" id="continue_passwd" placeholder="passwd">
<button type="submit" class="btn btn-mini btn-danger" >이어그리기</button> 
<a href="javascript:;" class="continueClose btn btn-mini btn-danger">이어그리기창 닫기</a>
</form>
</div>
<!--// 이어 그리기 폼 //-->

<!--// 옵션 폼 //-->
<div id="opFormDiv" class="text-right marginTop5" style="display:none;">
<form class="opForm form-inline margin0" method="POST" action="#">
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" id="idx" name="idx" value="">
<select id="op" name="op[pic]" class="span3">
<option selected="selected" >옵션</option>
<option value="more">접기</option>
<option value="secret">비밀</option>
</select>
<button type="submit" class="btn btn-mini btn-danger" >확인</button> 
<a href="javascript:;" class="opClose btn btn-mini btn-danger">옵션창 닫기</a>
</form>
</div>
<!--// 옵션 폼 //-->

<!--// 수정 폼 //-->
<div id="modifyForm" class="text-right" style="display:none;">
<p><a href="javascript:;" class="modifyClose"><span class="label">리플창 닫기</span></a></p>
<div></div>
</div>
<!--// 수정 폼 //-->

<!--// 그림 원본 박스용 스크립트 //-->
<script>
jQuery(document).ready(function($) {
	$('.lightbox_trigger').click(function(e) {
		e.preventDefault();
		var image_href = $(this).attr("href");
		var scrolltop = $(window).scrollTop();
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
<!--// 그림 원본 박스용 스크립트 //-->