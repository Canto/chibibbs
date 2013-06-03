<?php
if(!defined("__CHIBI__")) exit();
if($member->permission=="all" || $member->permission =="super"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminBoardCreateOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
게시판 생성
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>게시판 ID</p>
</td>
<td class="span9 td-right">
<input id="cid" class="input-xlarge" type="text" name="cid" placeholder="게시판 ID"  onblur="checkID()" required><p id="chk_id" class="help-inline"></p>
<p class="help-block">게시판 ID를 입력하여 주세요.<span class="text-warning">※ 영문+숫자만 가능</span></p>
<script type="text/javascript">
function checkID(){
	 if($("#cid").val() == ""){
	  alert("게시판 ID를 입력해 주세요.");
	  $('#cid').focus();
 }else{
  $.ajax({
   url: './admin.board.id.check.php',
   type: 'POST',
   data: {'cid':$('#cid').val()},
   dataType: 'html',
   success: function(data){
	   if(data == true){
	    $("#chk_id").html("<span class=\"text-success\">사용가능한 ID입니다.</span>");
	   }else{
	    $("#chk_id").html("<span class=\"text-error\">사용 중인 ID입니다.</span>");
		$("#cid").focus();
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
<p>스킨 설정</p>
</td>
<td class="span9 td-right">
<select name="skin">
<?php
	foreach(glob("../skin/*",GLOB_ONLYDIR) as $value){
			$skin = explode("/",$value);
			if($skin[2]=="CB_default")$s_chk="selected";
			else $s_chk="";
			echo "<option vlaue=\"".$skin[2]."\" ".$s_chk." >".$skin[2]."</option>";
			 }
?>
</select>
<p class="help-block">사용하실 스킨을 선택하여 주세요.</p>
</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>게시판 타이틀</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="title" placeholder="게시판 타이틀" required >
<p class="help-block">상단 브라우저 제목에 나타나는 값입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비공개 설정</p>
</td>
<td class="span9 td-right">
<select name="secret">
<option value="all">발행</option>
<option value="off">공개</option>
<option value="on">비공개</option>
<select>
<p class="help-block">게시판 공개 / 비공개 를 설정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비툴의 사용여부</p>
</td>
<td class="span9 td-right">
<select name="btool">
<option value="off">미사용</option>
<option value="on">사용</option>
<select>
<p class="help-block">비툴프로그램의 사용여부를 설정 할 수 있습니다.<br/><span class="text-warning">비툴홈페이지(<a href="http://btool.net" target="_blank">http://btool.net</a>)에서 구입 후 이용하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비공개 패스워드</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="password" name="passwd" placeholder="비공개 패스워드" required>
<p class="help-block">비공개 게시판일 경우 게시판에 접속할 때 필요한 패스워드 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>한 페이지당 표시할 그림 수</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page" placeholder="한 페이지당 표시할 그림 수" required value="5">
<p class="help-block">한 페이지당 표시될 그림의 갯수를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>페이지바의 페이지 수 </p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page_bar" placeholder="페이지바의 페이지 수" required value="10">
<p class="help-block">페이지바에 표시될 페이지 수를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최대 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_width" placeholder="그림의 최대 너비" required >
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최대 너비를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최대 높이</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_height" placeholder="그림의 최대 높이" required >
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최대 높이를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최소 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_width" placeholder="그림의 최소 너비" required >
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최소 너비를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최소 높이</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_height" placeholder="그림의 최소 높이" required >
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최소 높이를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 너비 기본값</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_width" placeholder="그림의 너비 기본값" required >
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 너비 기본값를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 높이 기본값</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_height" placeholder="그림의 높이 기본값" required >
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 높이 기본값를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>자동축소 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_thumbnail_width" placeholder="자동축소 너비" required >
<p class="help-block">해당 너비를 넘어가면 그림은 자동 축소 됩니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>IP 공개</p>
</td>
<td class="span9 td-right">
<select class="input-large" name="showip">
<option value="off">OFF</option>
<option value="admin">관리자 공개</option>
<option value="all">전체공개</option>
<select>
<p class="help-block">그림&코멘트 작성자의 IP를 공개합니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림 포인트</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_point" placeholder="그림 포인트" value="10">
<p class="help-block">그림 작성시 주어지는 포인트 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>코멘트 포인트</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="comment_point" placeholder="코멘트 포인트" value="5">
<p class="help-block">코멘트 작성시 주어지는 포인트 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>상단 외부페이지</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_head" placeholder="상단 외부페이지" >
<p class="help-block">게시판 상단에 나타 낼 외부 페이지를 지정 하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>하단 외부페이지</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_foot" placeholder="하단 외부페이지" >
<p class="help-block">게시판 하단에 나타 낼 외부 페이지를 지정 하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>상단 공지사항</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="head" style="resize:none;" placeholder="상단 공지사항"></textarea>
<p class="help-block">게시판 상단에 나타낼 공지사항의 내용을 적어주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>하단 공지사항</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="foot" style="resize:none;" placeholder="하단 공지사항"></textarea>
<p class="help-block">게시판 하단에 나타낼 공지사항의 내용을 적어주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>사용 가능한 태그목록</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="tag" style="resize:none;" >font,b,img</textarea>
<p class="help-block">코멘트와 이름부분에 사용가능한 태그 목록입니다.<br/>font,b,img 같이 <code> , </code> 로 구분하여 작성하여주세요.<br/><span class="text-warning"><code>iframe</code>,<code>embed</code>,<code>object</code> 태그등은 사용시 보안상 위험이 생길 수 있습니다.<br/>사용에 주의 하시기 바랍니다.</span></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>스팸IP 필터</p>
</td>
<td class="span9 td-right">
<p>
<select class="input-large" name="op">
<option value="ban">게시판 접근 금지</option>
<option value="write">글 / 그림 / 댓글 작성 금지</option>
</select>
</p>
<textarea rows="5" class="input-xxlarge" name="ip" style="resize:none;" ></textarea>
<p class="help-block">스팸 IP 필터 입니다. 차단할 IP를 적어주세요.<br/>여러아이피를 지정 할 경우 , (콤마)를 이용하여 구분하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>스팸 단어 필터</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="word" style="resize:none;"></textarea>
<p class="help-block">스팸 단어 필터 입니다.<br/>성인광고,바카라,aloha! 같이 , (콤마)를 이용하여 구분하여 주세요.</p>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
  <button type="submit" class="btn btn-success">게시판 생성</button>
  <button type="button" class="btn ">취소</button>
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