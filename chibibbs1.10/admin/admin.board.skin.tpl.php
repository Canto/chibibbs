<?php
if(!defined("__CHIBI__")) exit();
$tpl=fopen("../data/tpl/".$cid.".tpl.php","r");
$tpl_file = '';
while (!feof($tpl)){
$tpl_file = $tpl_file.fgets($tpl);
}
fclose($tpl);
$tpl_file = htmlspecialchars($tpl_file);
$reset_tpl=fopen("../skin/".$skin."/layout.php","r");
$reset_tpl_file = '';
while (!feof($reset_tpl)){
$reset_tpl_file = $reset_tpl_file.fgets($reset_tpl);
}
fclose($reset_tpl);
$reset_tpl_file = htmlspecialchars($reset_tpl_file);
if(bbs_permission($member->permission,$cid)=="true"){
?>
<script>
$(document).ready(function(){
$('#reset').click(function(){
	var reset_tpl = $('#reset_tpl').val();
	$("#tpl").val(reset_tpl);
	alert("스킨 초기화 완료!!");
	$("#tpl").focus();
});
});
</script>
<textarea id="reset_tpl" style="display:none;"><?php echo $reset_tpl_file;?></textarea>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminSkinTplOk">
<input name="skin" type="hidden" value="<?php echo $skin;?>">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
<a href="admin.php?cAct=adminSkinSetup&skin=<?=$skin?>&cid=<?=$cid?>" class="btn offset4 span4">스킨 설정</a>
</th>
</tr>
<tr>
<th colspan="2" class="span12">
스킨 디자인 수정
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>게시판 ID</p>
</td>
<td class="span9 td-right">
<input id="cid" class="input-xlarge" type="text" placeholder="게시판 ID"  value="<?php echo $cid;?>" disabled >
<input name="cid" type="hidden" value="<?php echo $cid;?>">
</td>
</tr>
<tr>
<td colspan="2" class="span12 td-right">
<textarea id="tpl" name="tpl" rows="25" class="span12" style="resize:none;">
<?php echo $tpl_file;?>
</textarea>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
  <button type="button" class="btn btn-warning" id="reset">초기화</button>
  <button type="submit" class="btn btn-success">설정 저장</button>
  <a class="btn" href="admin.php?cAct=adminBoardList">취소</a>
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
해당 게시판 관리자만 접속 가능한 페이지 입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
?>