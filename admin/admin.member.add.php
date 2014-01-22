<?php
if(!defined("__CHIBI__")) exit();
if($member->permission=="all" || $member->permission =="super"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminMemberAddOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
멤버 추가
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
   url: './admin.member.id.check.php',
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
<p class="help-block">멤버 패스워드 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>게시판 권한 선택</p>
</td>
<td class="span9 td-right">
<select id="permisssion" name="permission[]" multiple="multiple" required>
<option value="" selected>권한없음</option>
<option value="all">최고관리자</option>
<?php
$bbs_query = select("",$chibi_conn);
$i = 0;
while($bbs = mysql_fetch_array($bbs_query)){
	$bbs = (object) $bbs;
?>
<option value="<?php echo $bbs->cid; ?>" ><?php echo $bbs->cid; ?></option>
<?php
}
?>
</select>
<p class="help-block">게시판 권한을 설정 할 수 있습니다. 다중선택은 <code>Ctrl</code>키를 누르고 선택하여 주세요.<br/><span class="label label-warning">※주의</span> <span class="text-error"><b>권한없음과 게시판명의 다중선택</b></span> 혹은 <span class="text-error"><b>최고관리자와 게시판명의 다중선택</b></span>은 에러가 발생할 가능성이 있으므로 게시판ID만 선택하여 주시기 바랍니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>포인트</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="point" value="0">
<p class="help-block">멤버의 포인트 입니다.</p>
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
  <button type="submit" class="btn btn-success">멤버 추가</button>
  <a class="btn" href="admin.php?cAct=adminMemberList">취소</a>
</p>
</td>
</tr>
</tbody>
</table>
</form>
<?php
}else{
?>
<div class="span6 offset3 alert alert-error margin20">
<a class="close" href="javascript:history.go(-1);">&times;</a>
접속권한이 없습니다.<br/>
최고 관리자만 접속 가능한 페이지 입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
?>