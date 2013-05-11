<?php
if(!defined("__CHIBI__")) exit();
$query = select($cid,$chibi_conn);
$bbs = (object) mysql_fetch_array($query);
$bbs->spam = (object) unserialize($bbs->spam);
$bbs->notice = (object) unserialize($bbs->notice);
$bbs->op = (object) unserialize($bbs->op);
if(bbs_permission($member->permission,$bbs->cid)=="true"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminBoardSetupOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
게시판 설정
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>게시판 ID</p>
</td>
<td class="span9 td-right">
<input id="cid" class="input-xlarge" type="text" placeholder="게시판 ID"  value="<?php echo $bbs->cid;?>" disabled >
<input name="cid" type="hidden" value="<?php echo $bbs->cid;?>">
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
			if($skin[2]==$bbs->skin)$s_chk="selected";
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
<input class="input-xxlarge" type="text" name="title" placeholder="게시판 타이틀" value="<?php echo $bbs->title;?>" required >
<p class="help-block">상단 브라우저 제목에 나타나는 값입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비공개 설정</p>
</td>
<td class="span9 td-right">
<select name="secret">
<option value="off" <?php if($bbs->op->secret=="off") echo "selected"; ?>>공개</option>
<option value="on" <?php if($bbs->op->secret=="on") echo "selected"; ?>>비공개</option>
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
<option value="off" <?php if($bbs->op->btool=="off") echo "selected"; ?>>미사용</option>
<option value="on" <?php if($bbs->op->btool=="on") echo "selected"; ?>>사용</option>
<select>
<p class="help-block">비툴프로그램의 사용여부를 설정 할 수 있습니다.<br/><span class="text-warning">비툴홈페이지(<a href="http://btool.net" target="_blank">http://btool.net</a>)에서 구입 후 이용하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>비공개 패스워드</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="password" name="passwd" placeholder="비공개 패스워드">
<p class="help-block">비공개 게시판일 경우 게시판에 접속할 때 필요한 패스워드 입니다.<br/><span class="text-warning">패스워드 변경시에만 입력하여 주세요.</span></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>한 페이지당 표시할 그림 수</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page" placeholder="한 페이지당 표시할 그림 수" required value="<?php echo $bbs->op->pic_page;?>">
<p class="help-block">한 페이지당 표시될 그림의 갯수를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>페이지바의 페이지 수 </p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page_bar" placeholder="페이지바의 페이지 수" required value="<?php echo $bbs->op->pic_page_bar;?>">
<p class="help-block">페이지바에 표시될 페이지 수를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최대 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_width" placeholder="그림의 최대 너비" required value="<?php echo $bbs->op->pic_max_width;?>">
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최대 너비를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최대 높이</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_height" placeholder="그림의 최대 높이" required value="<?php echo $bbs->op->pic_max_height;?>">
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최대 높이를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최소 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_width" placeholder="그림의 최소 너비" required value="<?php echo $bbs->op->pic_min_width;?>">
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최소 너비를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 최소 높이</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_height" placeholder="그림의 최소 높이" required value="<?php echo $bbs->op->pic_min_height;?>">
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 최소 높이를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 너비 기본값</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_width" placeholder="그림의 너비 기본값" required value="<?php echo $bbs->op->pic_d_width;?>">
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 너비 기본값를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림의 높이 기본값</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_height" placeholder="그림의 높이 기본값" required value="<?php echo $bbs->op->pic_d_height;?>">
<p class="help-block">치비툴 혹은 비툴을 이용할 때 그릴 수 있는 그림의 높이 기본값를 입력하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>자동축소 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_thumbnail_width" placeholder="자동축소 너비" required value="<?php echo $bbs->op->pic_thumbnail_width;?>">
<p class="help-block">해당 너비를 넘어가면 그림은 자동 축소 됩니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>IP 공개</p>
</td>
<td class="span9 td-right">
<select class="input-large" name="showip">
<option value="off" <?php if($bbs->op->showip=="off") echo "selected"; ?>>OFF</option>
<option value="admin" <?php if($bbs->op->showip=="admin") echo "selected"; ?>>관리자 공개</option>
<option value="all" <?php if($bbs->op->showip=="all") echo "selected"; ?>>전체공개</option>
<select>
<p class="help-block">그림&코멘트 작성자의 IP를 공개합니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>그림 포인트</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_point" placeholder="그림 포인트" value="<?php echo $bbs->op->pic_point;?>">
<p class="help-block">그림 작성시 주어지는 포인트 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>코멘트 포인트</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="comment_point" placeholder="코멘트 포인트" value="<?php echo $bbs->op->comment_point;?>">
<p class="help-block">코멘트 작성시 주어지는 포인트 입니다.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>상단 외부페이지</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_head" placeholder="상단 외부페이지" value="<?php echo $bbs->op->include_head;?>">
<p class="help-block">게시판 상단에 나타 낼 외부 페이지를 지정 하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>하단 외부페이지</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_foot" placeholder="하단 외부페이지" value="<?php echo $bbs->op->include_foot;?>">
<p class="help-block">게시판 하단에 나타 낼 외부 페이지를 지정 하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>상단 공지사항</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="head" style="resize:none;" placeholder="상단 공지사항" ><?php echo $bbs->notice->head;?></textarea>
<p class="help-block">게시판 상단에 나타낼 공지사항의 내용을 적어주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>하단 공지사항</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="foot" style="resize:none;" placeholder="하단 공지사항"><?php echo $bbs->notice->foot;?></textarea>
<p class="help-block">게시판 하단에 나타낼 공지사항의 내용을 적어주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>사용 가능한 태그목록</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="tag" style="resize:none;" ><?php echo $bbs->tag;?></textarea>
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
<option value="ban" <?php if($bbs->spam->op=="ban") echo "selected"; ?>>게시판 접근 금지</option>
<option value="write" <?php if($bbs->spam->op=="write") echo "selected"; ?>>글 / 그림 / 댓글 작성 금지</option>
</select>
</p>
<textarea rows="5" class="input-xxlarge" name="ip" style="resize:none;" ><?php echo $bbs->spam->ip;?></textarea>
<p class="help-block">스팸 IP 필터 입니다. 차단할 IP를 적어주세요.<br/>여러아이피를 지정 할 경우 , (콤마)를 이용하여 구분하여 주세요.</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>스팸 단어 필터</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="word" style="resize:none;"><?php echo $bbs->spam->word;?></textarea>
<p class="help-block">스팸 단어 필터 입니다.<br/>성인광고,바카라,aloha! 같이 , (콤마)를 이용하여 구분하여 주세요.</p>
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