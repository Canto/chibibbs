<?php
if(!defined("__CHIBI__")) exit();
$query = select_skin($cid,$chibi_conn);
$skin = (object) mysql_fetch_array($query);
$skin->op = unserialize($skin->op);
if(get_magic_quotes_gpc()) $skin->op = array_map('stripslashes', $skin->op);
$skin->op = (object) $skin->op;
if(empty($skin->op->painter_icon)) $skin->op->painter_icon = "[작가글]";
if(empty($skin->op->bootstrap)) $skin->op->bootstrap = "off";
if(bbs_permission($member->permission,$skin->cid)=="true"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminSkinSetupOk">
<input name="skin" type="hidden" value="<?php echo $skin->skin_name;?>">
<input name="op[bootstrap]" type="hidden" value="off">
<!-- // 스킨제작자 표시용
<input name="op[author]" type="hidden" value='<a href="http://canto.btool.kr" target="_blank">Canto</a>'>
-->
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
<a href="admin.php?cAct=adminSkinTpl&cid=<?=$cid?>&skin=<?=$skin->skin_name?>" class="btn offset4 span4">스킨 디자인 수정</a>
</th>
</tr>
<tr>
<th colspan="2" class="span12">
스킨 설정
</th>
</tr>
<tr>
<th colspan="2" class="span12">
<pre>
스킨 이름	: 치비BBS Default 스킨
제작자		: Canto
홈페이지	: <a href="http://canto.btool.kr" target="_blank">http://canto.btool.kr</a>
버젼		: 1.10
</pre>
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
<td class="span3 td-left">
<p>링크 색상</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[link_color]" placeholder="링크 색" value="<?php echo $skin->op->link_color;?>"  >
<p class="help-inline">링크 색상을 입력하여 주세요. 예 > <code>#ffffff</code></p><br/><br/>
<input class="input-xlarge" type="text" name="op[hover_color]" placeholder="링크 마우스 오버 색" value="<?php echo $skin->op->hover_color;?>"  >
<p class="help-inline">링크에 마우스오버를 했을경우의 색상을 입력하여 주세요. 예 > <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>게시판 배경색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[background_color]" placeholder="게시판 배경색" value="<?php echo $skin->op->background_color;?>"  >
<p class="help-inline">게시판 배경색을 입력하여 주세요. 예 > <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>게시판 배경이미지</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[background_img]" placeholder="배경 이미지" value="<?php echo $skin->op->background_img;?>">
<select name="op[repeat]">
<option value="">반복 옵션</option>
<option value="repeat" <?php if($skin->op->repeat=="repeat") echo "selected"; ?>>반복</option>
<option value="repeat-x" <?php if($skin->op->repeat=="repeat-x") echo "selected"; ?>>수평반복</option>
<option value="repeat-y" <?php if($skin->op->repeat=="repeat-y") echo "selected"; ?>>수직반복</option>
<option value="no-repeat" <?php if($skin->op->repeat=="no-repeat") echo "selected"; ?>>반복없음</option>
<option value="fixed" <?php if($skin->op->repeat=="fixed") echo "selected"; ?>>고정</option>
<select>
<p class="help-inline">게시판 배경이미지 & 반복을 설정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>공지사항 <br/> 선색,선종류 & 배경색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[notice_border_color]" placeholder="공지 선 색 & 굵기" value="<?php echo $skin->op->notice_border_color;?>">
<select name="op[notice_border_type]">
<option value="">선 종류</option>
<option value="solid" <?php if($skin->op->notice_border_type=='solid') echo 'selected="selected"';?>>일반 선</option>
<option value="dotted" <?php if($skin->op->notice_border_type=='dotted') echo 'selected="selected"';?>>점(・) 선</option>
<option value="dashed" <?php if($skin->op->notice_border_type=='dashed') echo 'selected="selected"';?>>대쉬(-) 선</option>
<option value="double" <?php if($skin->op->notice_border_type=='double') echo 'selected="selected"';?>>이중 선</option>
<option value="groove" <?php if($skin->op->notice_border_type=='groove') echo 'selected="selected"';?>>홈 모양 선</option>
<option value="ridge" <?php if($skin->op->notice_border_type=='ridge') echo 'selected="selected"';?>>돌출 선</option>
<option value="inset" <?php if($skin->op->notice_border_type=='inset') echo 'selected="selected"';?>>내부 엠보싱</option>
<option value="outset" <?php if($skin->op->notice_border_type=='ouset') echo 'selected="selected"';?>>외부 엠보싱</option>
</select>
<p class="help-block">공지사항 선 색과 굵기를 입력하여 주세요.예 > <code>#ffffff 1px</code></p>
<input class="input-xlarge" type="text" name="op[notice_background_color]" placeholder="공지 배경 색" value="<?php echo $skin->op->notice_background_color;?>">
<p class="help-block">공지사항 배경 색을 입력하여 주세요. 예> <code>#ffffff</code></p>
<input class="input-xlarge" type="text" name="op[notice_font_color]" placeholder="공지 배경 색" value="<?php echo $skin->op->notice_font_color;?>">
<p class="help-block">공지사항 글자 색을 입력하여 주세요. 예> <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>테이블 외각 선</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_border_color]" placeholder="테이블 선 색상" value="<?php echo $skin->op->table_border_color;?>">
<p class="help-block">테이블 외각 선 색상 를 지정 할 수 있습니다.</p>
<input class="input-xlarge" type="text" name="op[table_border_size]" placeholder="테이블 선 굵기" value="<?php echo $skin->op->table_border_size;?>">
<p class="help-block">테이블 외각 선 굵기 를 지정 할 수 있습니다.</p>
<select name="op[table_border_type]">
<option value="">선 종류</option>
<option value="solid" <?php if($skin->op->table_border_type=='solid') echo 'selected="selected"';?>>일반 선</option>
<option value="dotted" <?php if($skin->op->table_border_type=='dotted') echo 'selected="selected"';?>>점(・) 선</option>
<option value="dashed" <?php if($skin->op->table_border_type=='dashed') echo 'selected="selected"';?>>대쉬(-) 선</option>
<option value="double" <?php if($skin->op->table_border_type=='double') echo 'selected="selected"';?>>이중 선</option>
<option value="groove" <?php if($skin->op->table_border_type=='groove') echo 'selected="selected"';?>>홈 모양 선</option>
<option value="ridge" <?php if($skin->op->table_border_type=='ridge') echo 'selected="selected"';?>>돌출 선</option>
<option value="inset" <?php if($skin->op->table_border_type=='inset') echo 'selected="selected"';?>>내부 엠보싱</option>
<option value="outset" <?php if($skin->op->table_border_type=='ouset') echo 'selected="selected"';?>>외부 엠보싱</option>
</select>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>테이블 내부 선</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_inner_border_color]" placeholder="테이블 내부 선 색상" value="<?php echo $skin->op->table_inner_border_color;?>">
<p class="help-block">테이블 내부 선 색상 를 지정 할 수 있습니다.</p>
<input class="input-xlarge" type="text" name="op[table_inner_border_size]" placeholder="테이블 내부 선 굵기" value="<?php echo $skin->op->table_inner_border_size;?>">
<p class="help-block">테이블 내부 선 굵기 를 지정 할 수 있습니다.</p>
<select name="op[table_inner_border_type]">
<option value="">선 종류</option>
<option value="solid" <?php if($skin->op->table_inner_border_type=='solid') echo 'selected="selected"';?>>일반 선</option>
<option value="dotted" <?php if($skin->op->table_inner_border_type=='dotted') echo 'selected="selected"';?>>점(・) 선</option>
<option value="dashed" <?php if($skin->op->table_inner_border_type=='dashed') echo 'selected="selected"';?>>대쉬(-) 선</option>
<option value="double" <?php if($skin->op->table_inner_border_type=='double') echo 'selected="selected"';?>>이중 선</option>
<option value="groove" <?php if($skin->op->table_inner_border_type=='groove') echo 'selected="selected"';?>>홈 모양 선</option>
<option value="ridge" <?php if($skin->op->table_inner_border_type=='ridge') echo 'selected="selected"';?>>돌출 선</option>
<option value="inset" <?php if($skin->op->table_inner_border_type=='inset') echo 'selected="selected"';?>>내부 엠보싱</option>
<option value="outset" <?php if($skin->op->table_inner_border_type=='ouset') echo 'selected="selected"';?>>외부 엠보싱</option>
</select>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>테이블 배경색(헤더)</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_background_color]" placeholder="테이블 배경색" value="<?php echo $skin->op->table_background_color;?>"  >
<p class="help-inline">테이블 배경색(헤더)을 입력하여 주세요. 예 > <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>로그 배경 색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[pic_background_color]" placeholder="로그 배경 색" value="<?php echo $skin->op->pic_background_color;?>">
<p class="help-block">로그 배경 색을 지장하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>리플 배경 색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[reply_background_color]" placeholder="리플 배경 색"  value="<?php echo $skin->op->reply_background_color;?>">
<p class="help-block">리플의 배경 색을 지정하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>리플 글자 색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[reply_text_color]" placeholder="리플 글자 색" value="<?php echo $skin->op->reply_text_color;?>">
<p class="help-block">리플의 글자색을 지정 하실수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>리리플 구분 바 색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[rereply_bar_color]" placeholder="리리플 구분 바 색"  value="<?php echo $skin->op->rereply_bar_color;?>">
<p class="help-block">리리플 구분 바의 색상을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>리리플 글자 색</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[rereply_text_color]" placeholder="리리플 글자 색"  value="<?php echo $skin->op->rereply_text_color;?>">
<p class="help-block">리리플의 글자 색상을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>하단 정렬 그림 사이즈</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_down]" placeholder="하단 정렬" value="<?php echo $skin->op->table_down;?>">
<p class="help-block">그림 너비가 지정수치 이상일 경우 코멘트가 그림 하단으로 이동합니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림 리사이즈 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[resize]" placeholder="리사이즈" value="<?php echo $skin->op->resize;?>">
<p class="help-block">그림을 리사이즈 할 너비 값을 지정 할 수 있습니다.(경우에 따라 자동으로 리사이즈 되는 경우도 있습니다.)</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비툴 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[btool_icon]" placeholder="비툴 아이콘" required value='<?php echo $skin->op->btool_icon;?>'>
<p class="help-block">비툴 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>치비툴 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[chibi_icon]" placeholder="치비툴 아이콘" required value='<?php echo $skin->op->chibi_icon;?>'>
<p class="help-block">치비툴 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>로드 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[load_icon]" placeholder="로드 아이콘" required value='<?php echo $skin->op->load_icon;?>'>
<p class="help-block">로드 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>새로고침 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[reflash_icon]" placeholder="새로고침 아이콘" required value='<?php echo $skin->op->reflash_icon;?>'>
<p class="help-block">새로고침 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>로그인 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[login_icon]" placeholder="로그인 아이콘" required value='<?php echo $skin->op->login_icon;?>'>
<p class="help-block">로그인 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>로그아웃 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[logout_icon]" placeholder="로그아웃 아이콘" required value='<?php echo $skin->op->logout_icon;?>'>
<p class="help-block">로그아웃 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>게시판관리 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[admin_icon]" placeholder="게시판관리 아이콘" required value='<?php echo $skin->op->admin_icon;?>'>
<p class="help-block">게시판관리 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>이모티콘 리스트 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[emoticon_icon]" placeholder="이모티콘 리스트 아이콘" required value='<?php echo $skin->op->emoticon_icon;?>'>
<p class="help-block">이모티콘 리스트 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>리플 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[reply_icon]" placeholder="리플 아이콘" required value='<?php echo $skin->op->reply_icon;?>'>
<p class="help-block">리플 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>수정 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[modify_icon]" placeholder="수정 아이콘" required value='<?php echo $skin->op->modify_icon;?>'>
<p class="help-block">수정 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>삭제 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[del_icon]" placeholder="삭제 아이콘" required value='<?php echo $skin->op->del_icon;?>'>
<p class="help-block">삭제 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림옵션 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[op_icon]" placeholder="그림 옵션 아이콘" required value='<?php echo $skin->op->op_icon;?>'>
<p class="help-block">그림 옵션 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>이어그리기 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[continue_icon]" placeholder="이어그리기 아이콘" required value='<?php echo $skin->op->continue_icon;?>'>
<p class="help-block">이어그리기 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>글쓰기 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[write_icon]" placeholder="글쓰기 아이콘" required value='<?php echo $skin->op->write_icon;?>'>
<p class="help-block">글쓰기 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>접기 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[more_icon]" placeholder="접기 아이콘" required value='<?php echo $skin->op->more_icon;?>'>
<p class="help-block">접기 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비밀 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[secret_icon]" placeholder="비밀 아이콘" required value='<?php echo $skin->op->secret_icon;?>'>
<p class="help-block">비밀 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>홈페이지 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[hp_icon]" placeholder="홈페이지 아이콘" required value='<?php echo $skin->op->hp_icon;?>'>
<p class="help-block">홈페이지 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>작가글 아이콘</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[painter_icon]" placeholder="작가글 아이콘" required value='<?php echo $skin->op->painter_icon;?>'>
<p class="help-block">작가글 아이콘을 지정 할 수 있습니다.</p>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
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