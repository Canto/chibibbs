<?php
if(!defined("__CHIBI__")) exit();
$user_id = $_GET['user_id'];

$query = member_list($user_id,$chibi_conn);
$member_list = (object) mysql_fetch_array($query);
$member_list->profile = unserialize($member_list->profile);
$member_list->profile = (object) $member_list->profile;
$member_list->op = unserialize($member_list->op);
$member_list->op = (object) $member_list->op;

$permission = explode(",",$member_list->permission);


if($member->permission=="all" || $member->permission=="super"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminMemberSetupOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
멤버 정보 수정
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>멤버 ID</p>
</td>
<td class="span9 td-right">
<input name="user_id" class="input-xlarge" type="text" placeholder="멤버 ID"  value="<?php echo $member_list->user_id;?>" disabled >
<input name="user_id" type="hidden" value="<?php echo $member_list->user_id;?>">
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>닉네임</p>
</td>
<td class="span9 td-right">
<input name="nickname" class="input-xlarge" type="text" placeholder="닉네임"  value="<?php echo $member_list->nickname;?>" required>
<p class="help-block">닉네임을 적어 주세요.</p>
</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비밀번호</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="password" name="passwd" placeholder="패스워드">
<p class="help-block">멤버 패스워드 입니다.<br/><span class="text-warning">패스워드 변경시에만 입력하여 주세요.</span></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>게시판 권한 선택</p>
</td>
<td class="span9 td-right">
<?php
if($permission[0]=="super") echo "<input type=\"hidden\" name=\"permission[]\" value=\"".$permission[0]."\">";
?>
<select id="permisssion" name="permission[]" multiple="multiple" required <?php if($permission[0]=="super") echo "disabled title=\"수정불가 항목입니다.\"";?>>
<option value="" <?php if(empty($permission[0])==true) echo "selected"; ?>>권한없음</option>
<option value="all" <?php if($permission[0]=="all") echo "selected"; ?>>최고관리자</option>
<?php
$bbs_query = select("",$chibi_conn);
$i = 0;
while($bbs = mysql_fetch_array($bbs_query)){
	$bbs = (object) $bbs;
	 if($permission[$i]==$bbs->cid){ 
		 $select = "selected";
		 $i++;
	 }else{
		$select = "";
	 }
?>
<option value="<?php echo $bbs->cid; ?>" <?php echo $select; ?>><?php echo $bbs->cid; ?></option>
<?php
}
?>
</select>
<p class="help-block">게시판 권한을 설정 할 수 있습니다. 다중선택은 <code>Ctrl</code>키를 누르고 선택하여 주세요.<br/><span class="label label-warning">※주의</span> <span class="text-warning"><b>권한없음과 게시판명의 다중선택</b></span> 혹은 <span class="text-warning"><b>최고관리자와 게시판명의 다중선택</b></span>은 에러가 발생할 가능성이 있습니다.<br/>선택에 주의하여 주시기 바랍니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>포인트</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="point" value="<?php echo $member_list->point;?>">
<p class="help-block">멤버의 포인트 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>프로필</p>
</td>
<td class="span9 td-right">
<div class="input-prepend"><p><span class="add-on">프로필 이미지Ⅰ</span><input class="input-xxlarge" type="text" name="img1" value="<?php if(empty($member_list->profile)==false) echo $member_list->profile->img1;?>" placeholder="프로필 이미지는 주소로만 입력하여 주세요 http://img.net/profile1.jpg"></p></div>
<div class="input-prepend"><p><span class="add-on">프로필 이미지Ⅱ</span><input class="input-xxlarge" type="text" name="img2" value="<?php if(empty($member_list->profile)==false) echo $member_list->profile->img2;?>" placeholder="프로필 이미지는 주소로만 입력하여 주세요 http://img.net/profile2.jpg"></p></div>
<div class="input-prepend"><p><span class="add-on">프로필 이미지Ⅲ</span><input class="input-xxlarge" type="text" name="img3" value="<?php if(empty($member_list->profile)==false) echo $member_list->profile->img2;?>" placeholder="프로필 이미지는 주소로만 입력하여 주세요 http://img.net/profile3.jpg"></p></div>
<textarea rows="5" class="input-xxlarge" name="text" style="resize:none;"><?php if(empty($member_list->profile)==false) echo $member_list->profile->text;?></textarea>
<p class="help-block">멤버 프로필 입니다. <span class="text-warning">프로필 이미지는 주소로만 입력하여 주세요 <code>예) http://img.net/profile.jpg</code></span></p>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
<?php if($permission[0]=="super" && $member->permission!="super")
{
?> 
<span class="label label-important">※알림</span> <span class="text-error">해당 멤버의 정보를 수정할 수 있는 권한이 없습니다.</span>
<?php
}else{
?>
<button type="submit" class="btn btn-success">설정 저장</button>
<?php
}
?>
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