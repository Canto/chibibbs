<?php
if(!defined("__CHIBI__")) exit();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS ver <?=$chibi_ver?> 멤버 가입</title>
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
<form class="form-horizontal" method="post" action="admin.php?cAct=adminMemberAddOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
멤버 가입
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>멤버 ID</p>
</td>
<td class="span9 td-right">
<input id="user_id" name="user_id" class="input-xlarge" type="text" placeholder="멤버 ID" onblur="checkID()" required><p id="chk_id" class="help-inline"></p>
<p>멤버 ID를 입력하여 주세요.<span class="text-warning">※ 영문+숫자만 가능</span></p>
<script type="text/javascript">
function checkID(){
	 if($("#user_id").val() == ""){
	  alert("멤버 ID를 입력해 주세요.");
	  $('#user_id').focus();
 }else{
  $.ajax({
   url: '../admin/admin.member.id.check.php',
   type: 'POST',
   data: {'user_id':$('#user_id').val()},
   dataType: 'html',
   success: function(data){
	   if(data == true){
	    $("#chk_id").html("<span class=\"text-success\">사용가능한 ID입니다.</span>");
	   }else{
	    $("#chk_id").html("<span class=\"text-error\">사용 중인 ID입니다.</span>");
		$("#user_id").focus();
	   }
   }
  });
 }
}
</script>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>닉네임</p>
</td>
<td class="span9 td-right">
<input name="nickname" class="input-xlarge" type="text" placeholder="닉네임"  required>
<p class="help-block">닉네임을 적어 주세요.</p>
</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비밀번호</p>
</td>
<td class="span9 td-right">
<input id="passwd" class="input-large" type="password" name="passwd" placeholder="패스워드" required>
<p class="help-block">패스워드를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>프로필</p>
</td>
<td class="span9 td-right">
<div class="input-prepend"><p><span class="add-on">프로필 이미지Ⅰ</span><input class="input-xxlarge" type="text" name="img1" placeholder="프로필 이미지는 주소로만 입력하여 주세요 http://img.net/profile1.jpg"></p></div>
<div class="input-prepend"><p><span class="add-on">프로필 이미지Ⅱ</span><input class="input-xxlarge" type="text" name="img2" placeholder="프로필 이미지는 주소로만 입력하여 주세요 http://img.net/profile2.jpg"></p></div>
<div class="input-prepend"><p><span class="add-on">프로필 이미지Ⅲ</span><input class="input-xxlarge" type="text" name="img3" placeholder="프로필 이미지는 주소로만 입력하여 주세요 http://img.net/profile3.jpg"></p></div>
<textarea rows="5" class="input-xxlarge" name="text" style="resize:none;"></textarea>
<p class="help-block">멤버 프로필 입니다. <span class="text-warning">프로필 이미지는 주소로만 입력하여 주세요 <code>예) http://img.net/profile.jpg</code></span></p>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
  <button type="submit" class="btn btn-success">멤버 가입</button>
  <a class="btn" href="#">취소</a>
</p>
</td>
</tr>
</tbody>
</table>
</form>
</body>
</html>