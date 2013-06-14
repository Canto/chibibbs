<?php
/*
게시판 스킨 설정 SQL Query 처리 페이지
filename : skin.sql.php
========== 설정 방법 =============
각 변수에 사용자변수 추가 가능
추가예 변수명 test,test1
$op변수 하단 'messege'=>serialize($messege) 뒤에, 를 붙임
'messege'=>serialize($messege), 이렇게
그뒤 개행(줄바꿈) 을 한뒤 변수를 추가
'test'=>'변수값',
'test1'=>'변수값'
주의점 : 맨 마지막 변수 설정이 끝난뒤에는 , 를 붙이지 말아야함
*/

/////////////////////////////////////////////////////////////////
/*기본 설정*/
$d_skin = "default_EX"; //스킨명 (영문,폴더명과 일치하여야함)

$d_op = array(
	'background_color'=>'#ffffff',
	'background_img'=>'',
	'repeat'=>'',
	'notice_border_color'=>'',
	'notice_border_type'=>'',
	'notice_background_color'=>'',
	'table_border_color'=>'#dddddd',
	'table_border_size'=>'1px',
	'table_border_type'=>'solid',
	'table_inner_border_color'=>'#dddddd',
	'table_inner_border_size'=>'1px',
	'table_inner_border_type'=>'solid',		
	'pic_border_hover'=>'',
	'pic_background_color'=>'#ffffff',
	'table_background_color'=>'#ffffff',
	'reply_background_color'=>'#ffffff',
	'reply_text_color'=>'',
	'rereply_bar_color'=>'',
	'rereply_text_color'=>'',
	'top_menu_icon_color'=>'',
	'resize'=>'400',
	'table_down'=>'9999',
	'size'=>'show',
	'tool'=>'show',
	'time'=>'show',
	'time_type'=>'Y년m월d일 H시i분s초',
	'more_icon'=>'<img src="skin/default_EX/images/more.png">',
	'secret_icon'=>'<img src="skin/default_EX/images/secret.png">',
	'btool_icon'=>'<img src="skin/default_EX/images/btool.png">',
	'chibi_icon'=>'<img src="skin/default_EX/images/chibi.png">',
	'load_icon'=>'<img src="skin/default_EX/images/load.png">',
	'reply_icon'=>'<img src="skin/default_EX/images/re.png">',
	'modify_icon'=>'<img src="skin/default_EX/images/mod.png">',
	'del_icon'=>'<img src="skin/default_EX/images/del.png">',
	'emoticon_icon'=>'<img src="skin/default_EX/images/emoticon.png">',
	'continue_icon'=>'<img src="skin/default_EX/images/continue.png">',
	'login_icon'=>'<img src="skin/default_EX/images/login.png">',
	'logout_icon'=>'<img src="skin/default_EX/images/logout.png">',
	'op_icon'=>'<img src="skin/default_EX/images/op.png">',
	'reflash_icon'=>'<img src="skin/default_EX/images/reflash.png">',
	'admin_icon'=>'<img src="skin/default_EX/images/admin.png">',
	'write_icon'=>'<input type="image" src="skin/default_EX/images/write.png" class="cmtmodify-submit" />',
	'hp_icon'=>'<img src="skin/default_EX/images/hp.png">',
	'pinater_icon'=>'[작가글]',
	'bootstrap'=>'on'
); // 스킨에서 사용되는 사용자 옵션


////////////////////////////////////////////////////////////
//if($type=="skin_m"){
//	$op = $_POST['op'];
////////////////////////////////////////////////////////////
//}
//if(get_magic_quotes_gpc()) $op = stripslashes($op);

/* 이 아래로는 수정하지 말것!!! 수정시 일어나는 오류에 대해선 책임 지지 않음 */
//게시판 생성시 초기 설정
$skin_insert_string = "INSERT INTO `chibi_skin` (`cid`, `skin_name`, `op`) VALUES ('".mysql_real_escape_string($cid)."', '".mysql_real_escape_string($d_skin)."','".mysql_real_escape_string(serialize($d_op))."')";
//게시판설정에서 스킨변경시 초기 설정
$uskin_db = "UPDATE `chibi_skin` SET `cid`='".mysql_real_escape_string($cid)."',  `skin_name`='".mysql_real_escape_string($d_skin)."', `op`='".mysql_real_escape_string(serialize($d_op))."' WHERE `cid`='".mysql_real_escape_string($cid)."'";
//스킨설정 페이지에서 업데이트시 설정
$update_db = "UPDATE `chibi_skin` SET `cid`='".mysql_real_escape_string($cid)."',  `skin_name`='".mysql_real_escape_string($d_skin)."', `op`='".mysql_real_escape_string(serialize($op))."' WHERE `cid`='".mysql_real_escape_string($cid)."' and `skin_name`='".mysql_real_escape_string($d_skin)."'";
?>