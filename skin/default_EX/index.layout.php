<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=3.0">
<meta name="robots" content="noindex,nofollow">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<?php 
if($skin->op->bootstrap=="off"){ 
	echo '<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">';
}else if($skin->op->bootstrap=="notuse"){

}else{ 
echo '<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">';
echo '<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>';
}
?>
<script type="text/javascript">
$(document).ready(function() {

    $("#bbs_passwd").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);

        if (code == 13) {
        	secret();
            return false;
        }
    });

});
function secret(){
	$.ajax({
   url: './admin/admin.board.secret.check.php',
   type: 'POST',
   data: {'cid':"<?=$cid?>",'passwd':$('#bbs_passwd').val()},
   dataType: 'html',
   success: function(data){
	   if(data == true){
			alert("접속 완료!!");
			location.href="./index.php?cid=<?=$cid?>";
	   }else{
	    alert("비밀번호가 틀립니다.");
	   }
   }
  });
}
function member_logout(){
	$.ajax({
   url: './member_logout.php',
   type: 'POST',
   data: {'cid':"<?=$cid?>"},
   dataType: 'html',
   success: function(data){
	   if(data == true){
			alert("멤버 로그아웃 완료!!");
			location.href="./index.php?cid=<?=$cid?>";
	   }else{
	    alert("멤버 로그인 상태가 아닙니다.");
	   }
   }
  });
}
</script>
<script src="js/bbs.fn.js"></script>
<title><?php echo $bbs->title?></title>
<style type="text/css">
.marginTop20{margin-top:20px;}
.secret-passwd{border-bottom:1px solid #3a87ad !important;}
.offsetreset{width:0px !important;height:0px;min-height:0px !important;}
</style>
<link href="skin/<?=$bbs->skin?>/skin.css" rel="stylesheet">
<style type="text/css">
<?php include "skin/".$bbs->skin."/skin.css.php"; /* 유저설정 CSS */ ?>
</style>
</head>
<body>
<div class="row-fluid">
<div class="span12 marginTop20">
<input type="hidden" id="bbs_cid" value="<?=$cid?>">
<input type="hidden" id="bbs_page" value="<?=$page?>">
<input type="hidden" id="bbs_session_id" value="<?=session_id()?>">
<input type="hidden" id="pic_d_width" value="<?=$bbs->op->pic_d_width?>">
<input type="hidden" id="pic_d_height" value="<?=$bbs->op->pic_d_height?>">
<?php 
if($bbs->op->include_head){
	include_once $bbs->op->include_head;
}
?>

<?php
	if($bbs->op->secret=="on" && $connect_permission == false && $permission == false){/* 게시판이 비공개 일 경우*/
?>
<div class="container">
<div class="span6 offset3 alert alert-info">
<form class="form-horizontal" id="secretForm" method="post" enctype="multipart/form-data">
<legend class="secret-passwd"><span class="text-info">게시판 접속 패스워드 입력 :: 게시판 - <?php echo $cid;?></span></legend>
<div class="control-group">
    <label class="control-label" for="inputInst">패스워드</label>
    <div class="controls">
	  <input name="passwd" class="input-large" id="bbs_passwd" type="password" placeholder="게시판 접속 패스워드 입력" required>
    </div>
</div>
<p class="text-right"><a href="javascript:secret();" id="addEmoticon" class="btn btn-primary">게시판 들어가기</a></p>
</form>
</div>
</div>
<?php
}else{
	switch($cAct){
	case "picDraw" :
		include "lib/draw.php";
		break;
	case "picContinue" :
		include "lib/draw.php";
		break;
	default:
		include "data/".$bbs->cid."/tpl/".$bbs->cid.".tpl.compiled.php";
		break;
	}
}
?>
<?php 
if($bbs->op->include_foot){
	include_once $bbs->op->include_foot;
}
?>
</div>
<div class="container text-right">
<?php if(empty($cAct)==true){?>
<form class="form-search form-inline" method="GET" action="index.php">
<input type="hidden" name="cid" value="<?=$cid?>">
<select name="search" style="width:100px">
<option>선택</option>
<option value="no" <?php if($search=="no") echo "selected=\"selected\"";?>>그림번호</option>
<option value="name" <?php if($search=="name") echo "selected=\"selected\"";?>>이름</option>
<option value="comment" <?php if($search=="comment") echo "selected=\"selected\"";?>>코멘트</option>
<option value="memo" <?php if($search=="memo") echo "selected=\"selected\"";?>>메모</option>
</select>
<input name="keyword" type="text" class="span2 input-keyword" value="<?=$keyword?>">

<button type="submit" class="btn btn-info btn-search">검색</button>
</form>
<?php } ?>
<p>
Chibi Tool BBS ver <?=$chibi_ver?> &copy; <a href='http://canto.btool.kr' target='_blank'>Canto</a>
<?php if($skin->op->author){?>
| Skin by <?=$skin->op->author?>
<?}?>
<br/><br/></p>
</div>
</div>
</body>
</html>
