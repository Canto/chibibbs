<?php
if(!defined("__CHIBI__")) exit();
/* 
게시판 관련 함수
*/
//print_r(explode(";",$_SERVER['HTTP_USER_AGENT']))
	function count_up($cid,$chibi_conn){
		$session = session_id();
		$date = date("YmdHD");
		if(empty($cid)==false){
			$chk_sql = "SELECT * FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND `ip`='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' AND `date`='".mysql_real_escape_string($date)."'";
			$chk_query = mysql_query($chk_sql,$chibi_conn);
			$chk = (object) mysql_fetch_array($chk_query);	
			if(empty($chk->cid)==true){
				$sql = "INSERT INTO `chibi_log` (`cid` ,`ip` ,`session` ,`date` ) VALUES ('".mysql_real_escape_string($cid)."',  '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."',  '".mysql_real_escape_string($session)."',  '".mysql_real_escape_string($date)."')";
				$query = mysql_query($sql,$chibi_conn);
				return $query;
			}
		}
	}
	function select($cid,$chibi_conn){ /* 게시판 선택 */
		if(empty($cid)==true){
		$string = "SELECT * FROM `chibi_admin`";
		}else{
		$string = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($cid)."'";
		}
		$query = mysql_query($string,$chibi_conn);
		return $query;
	}
	function select_skin($cid,$chibi_conn){ /* 게시판 선택 */
		$string = "SELECT * FROM `chibi_skin` where `cid`='".mysql_real_escape_string($cid)."'";
		$query = mysql_query($string,$chibi_conn);
		return $query;
	}
	function member_list($user_id,$chibi_conn){ /* 멤버 리스트 */
		if(empty($user_id)==true){
			$sql = "SELECT * FROM `chibi_member` ORDER BY `mno` DESC";
		}else{
			$sql = "SELECT * FROM `chibi_member` WHERE `user_id` = '".mysql_real_escape_string($user_id)."'";
		}
		$query = mysql_query($sql,$chibi_conn);
		return $query;
	}
	function news_pic($chibi_conn,$op){
		if(empty($op)==true){
		$sql = "SELECT * FROM `chibi_pic` WHERE `type`='picture' ORDER BY `idx` DESC LIMIT 0,10";
		}else{
		$sql = "SELECT * FROM `chibi_pic` WHERE `type`='picture' AND ".$op." ORDER BY `idx` DESC LIMIT 0,10";
		}
		$query = mysql_query($sql,$chibi_conn);
		return $query;
	}
function str_cut($String, $MaxLen, $ShortenStr) { 
$StringLen = strlen($String); // 원래 문자열의 길이를 구함 
$EffectLen = $MaxLen - strlen($ShortenStr); 
if ( $StringLen < $MaxLen )return $String;
for ($i = 0; $i <= $EffectLen; $i++) { 
$LastStr = substr($String, $i, 1); 
if ( ord($LastStr) > 127 ) $i++; } 
$RetStr = substr($String, 0, $i);  
return $RetStr .= $ShortenStr; 
}
	function news_comment($chibi_conn,$op){
		if(empty($op)==true){
		$sql = "SELECT * FROM `chibi_comment` ORDER BY `idx` DESC LIMIT 0,10";
		}else{
		$sql = "SELECT * FROM `chibi_comment` WHERE ".$op." ORDER BY `idx` DESC LIMIT 0,10";
		}
		$query = mysql_query($sql,$chibi_conn);
		return $query;
	}
	function pic($cid,$start,$end,$chibi_conn,$search,$keyword){
		if($search == "name")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`name`LIKE'".mysql_real_escape_string($keyword)."' AND  `chibi_comment`.`cid`='".mysql_real_escape_string($cid)."'  AND  `chibi_pic`.`cid` =  '".mysql_real_escape_string($cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$start.",".$end;
		else if($search == "comment")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`comment` LIKE '%".mysql_real_escape_string($keyword)."%' AND  `chibi_comment`.`cid` =  '".mysql_real_escape_string($cid)."'  AND  `chibi_pic`.`cid` =  '".mysql_real_escape_string($cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$start.",".$end;
		else if($search == "no")$string = "SELECT * FROM `chibi_pic` WHERE cid='".mysql_real_escape_string($cid)."' AND no='".mysql_real_escape_string($keyword)."'";
		else $string = "SELECT * FROM `chibi_pic` where `cid`='".mysql_real_escape_string($cid)."' ORDER BY `no` DESC LIMIT ".$start.",".$end;
		$query = mysql_query($string,$chibi_conn);
		return $query;
	}
	function comment($cid,$pic_no,$chibi_conn){
		$string = "SELECT * FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($cid)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' 
ORDER BY `no` ASC , `depth` ASC, `rtime` ASC";
		$query = mysql_query($string,$chibi_conn);
		return $query;

	}
	function member($user_id,$chibi_conn){ /* 멤버 정보 */
		$sql = "SELECT * FROM `chibi_member` WHERE user_id='".mysql_real_escape_string($user_id)."'";
		$query = mysql_query($sql,$chibi_conn);
		$member = (object) mysql_fetch_array($query);
		return $member;
	}
	function bbs_permission($permission,$cid){
		$array = explode(",",$permission);
		$i = 0;
		while($i<count($array)){
			if($array[$i] == $cid || $array[$i] == "all" || $array[$i] == "super" ) return "true";
			$i++;
		}
		return "false";
	}
	function login_ok($user_id,$chibi_conn){
		$time = time();
		$session = session_id();
		$update = "UPDATE `chibi_member` SET `lastlogin` ='".mysql_real_escape_string($time)."', `session`='".mysql_real_escape_string($session)."' WHERE  user_id='".mysql_real_escape_string($user_id)."'";
		mysql_query($update,$chibi_conn);
		$chk = mysql_error(); 
		if(empty($chk)==true)return true;
		else return false;
	}

	function logout($user_id,$chibi_conn){
		$time = time();
		$session = session_id();
		$update = "UPDATE `chibi_member` SET `lastlogin` ='".mysql_real_escape_string($time)."', `session`='' WHERE  user_id='".mysql_real_escape_string($user_id)."'";
		mysql_query($update,$chibi_conn);
		$chk = mysql_error();
		if(empty($chk)==true)return true;
		else return false;
	}

	function login_check($chibi_conn){ /* 로그인 체크 */
		global $member;
		$time = time();
		$session = session_id();
		$sql = "SELECT * FROM `chibi_member` WHERE session='".$session."' ORDER BY `lastlogin` DESC";
		$query = mysql_query($sql,$chibi_conn);
		$member_array = mysql_fetch_array($query);
		$member = (object) $member_array;
		if(isset($member->lastlogin)){
		if($member->lastlogin == 0  || $time - $member->lastlogin > 10800){
			return false;
		}else{
			$update = "UPDATE `chibi_member` SET `lastlogin` ='".mysql_real_escape_string($time)."' WHERE  session='".mysql_real_escape_string($session)."'";
			mysql_query($update,$chibi_conn);
			return true;
		}
		}else{
			return false;
		}
	}
	function make_tpl($skin,$cid){
		$tpl = fopen("../skin/".$skin."/layout.php", "r");
		$tpl_file = '';
		while (!feof($tpl)){
		$tpl_file = $tpl_file.fgets($tpl);
		}
		$fp=fopen("../data/".$cid."/tpl/".$cid.".tpl.php","w");
		fwrite($fp,$tpl_file);
		fclose($fp);
		fclose($tpl);
		chmod("../data/".$cid."/tpl/".$cid.".tpl.php",0644);
	}
	function count_bbs($table,$op,$chibi_conn){ /* 데이터 갯수 체크 후 반환*/ 
		if(empty($op)==true){
		$sql = "SELECT count(*) FROM `chibi_".mysql_real_escape_string($table)."`";
		}else{
		$sql = "SELECT count(*) FROM `chibi_".mysql_real_escape_string($table)."` WHERE ".$op;
		}
		$query = mysql_query($sql,$chibi_conn);
		$row = mysql_fetch_row($query);
		$chk = mysql_error();
		if(empty($chk)==true) return $row[0];
		else return $chk;
	}

	function setup_check($chibi_conn){ /* 게시판 설치 체크 */
		$db_check = (object) array("status"=>"","admin"=>"","skin"=>"","pic"=>"","comment"=>"","tpl"=>"","member"=>"","emoticon"=>"","log"=>"");
		if(is_resource($chibi_conn)) $db_check->status = true;
		else $db_check->status = false;
		if(is_resource(@mysql_query("DESC chibi_admin",$chibi_conn))) $db_check->admin = true;
		else $db_check->admin = false;
		if(is_resource(@mysql_query("DESC chibi_skin",$chibi_conn))) $db_check->skin = true;
		else $db_check->skin = false;
		if(is_resource(@mysql_query("DESC chibi_pic",$chibi_conn))) $db_check->pic = true;
		else $db_check->pic = false;
		if(is_resource(@mysql_query("DESC chibi_comment",$chibi_conn))) $db_check->comment = true;
		else $db_check->comment = false;
		if(is_resource(@mysql_query("DESC chibi_tpl",$chibi_conn))) $db_check->tpl = true;
		else $db_check->tpl = false;
		if(is_resource(@mysql_query("DESC chibi_member",$chibi_conn))) $db_check->member = true;
		else $db_check->member = false;
		if(is_resource(@mysql_query("DESC chibi_emoticon",$chibi_conn))) $db_check->emoticon = true;
		else $db_check->emoticon = false;
		if(is_resource(@mysql_query("DESC chibi_log",$chibi_conn))) $db_check->log = true;
		else $db_check->log = false;

		if(($db_check->status && $db_check->admin && $db_check->skin && $db_check->pic && $db_check->comment && $db_check->tpl && $db_check->member && $db_check->emoticon && $db_check->log)==true){
			return true;
		}else{
			return false;
		}
	}
	function rmdir_rf($dirname) {
		$files = glob($dirname."/*"); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}
		rmdir($dirname);
	}
	function rmfile($dirname) {
		$files = glob($dirname."/*"); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}
	}
	function rmemoticon($filename) {
		  if(is_file($filename)){
		    unlink($filename);
		}
	}
	
	function delfile($filename) {
		  if(is_file($filename)){
		    unlink($filename);
		}
	}
	
	function ip_check($ip){
		if(empty($ip)==false){ // SAPM IP check and Block
			$chk_ip = explode(',',$ip);
			if(is_array($chk_ip)){
				foreach($chk_ip as $ban){
					if(eregi($ban,$_SERVER["REMOTE_ADDR"])){
					echo '<script>alert(\'해당 IP는 접근 금지된 IP입니다.\');<script>';
					exit;
					}
				}
			}
		}
	}
	
	function device_check(){
	if (strstr($_SERVER['HTTP_USER_AGENT'], "iPod") || strstr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strstr($_SERVER['HTTP_USER_AGENT'], "iPad") || strstr($_SERVER['HTTP_USER_AGENT'], "Android")|| strstr($_SERVER['HTTP_USER_AGENT'], "Mobile") || strstr($_SERVER['HTTP_USER_AGENT'], "Windows Phone")){
		$device = "mobile";
	}else{
		$device = "pc";
	}
		return $device;
	}


function spam_filter($comment,$word){
$chk_spam = explode(",",$word);
if($chk_spam[0]!=null){
	foreach($chk_spam as $spam){
		if(strpos($comment,$spam)!=0){
			return $spam;
		}
	}
}
}


function htmlFilter($memo,$use_html=0,$use_tag='')
{
    if($use_html == 1) // html tag 허용시
    {
        $memo = str_replace("<", "&lt;", $memo); // 우선 tag를 제거
        $tag = explode(",", $use_tag);
        
        $tag_cnt = count($tag);
        for($i=0; $i < $tag_cnt; $i++)   // 허용된 tag만 사용가능토록 처리
        {
            $memo = preg_replace("@&lt;".$tag[$i]." @", "<".$tag[$i]." ", $memo);
            $memo = preg_replace("@&lt;".$tag[$i].">@", "<".$tag[$i].">", $memo);
            $memo = preg_replace("@&lt;/".$tag[$i]."@", "</".$tag[$i], $memo);
        }
  
    } else {   // html tag 불허시
        $memo = str_replace("<", "&lt;", $memo);
        $memo = str_replace(">", "&gt;", $memo);
    }
 
    return $memo;
}
function emoticon($comment,$cid,$chibi_conn) //작성중
{
	$sql = "SELECT * FROM `chibi_emoticon` WHERE cid='".mysql_real_escape_string($cid)."'";
	$query = mysql_query($sql,$chibi_conn);
	while($em = mysql_fetch_assoc($query)){
          $emarray[] = $em;
  }
	$emLIST = $emarray;
	if(is_array($emLIST)){
	foreach($emLIST as $emoticon){
		$comment = str_replace($emoticon['inst'],"<img src=\"./".$emoticon['url']."\" alt=\"".$emoticon['inst']."\" title=\"".$emoticon['inst']."\"/>",$comment);
	}
	}
    return $comment;
}

function load($skin){ //템플릿 파일 로드
		$tpl = fopen("../skin/".$skin."/layout.php", "r");
		$tpl_file = '';
		while (!feof($tpl)){
		$tpl_file = $tpl_file.fgets($tpl);
		}
		return $tpl_file;
		fclose($tpl);
}
function convert($content){ // 템플릿 변수를 PHP변수로 컴파일
		$startpic = "<?php
		$pic_query = pic($cid,$start,$limit,$chibi_conn,$search,$keyword); /* 그림 불러오기 */
		while($pic = mysql_fetch_array($pic_query)){ /* 반복문 시작 */
		$pic = (object) $pic;  
		if(empty($pic->op)==false){
		$pic->op = unserialize($pic->op);
		$pic->op = (object) $pic->op;
		}
		?>";
		$startcomment = "<?php
		\$no = 0;
		\$cmt_query = comment(\$cid,\$pic->no,\$chibi_conn);
		while(\$comment = mysql_fetch_array(\$cmt_query)){
		\$comment = (object) \$comment;
		if(empty(\$comment->op)==false){
		\$comment->op = unserialize(\$comment->op);
		\$comment->op = (object) \$comment->op;
		\$no = \$comment->no;
		if(get_magic_quotes_gpc()) \$comment->comment = stripslashes(\$comment->comment); 
		}
		?>";
		$content = str_replace('<@--START:PIC--@>',$startpic, $content);
		$content = str_replace('<@--END:PIC--@>',"<?php } ?>", $content);
		$content = str_replace('<@--START:COMMENT--@>',$startcomment, $content);
		$content = str_replace('<@--END:COMMENT--@>',"<?php } ?>", $content);
//		$content = preg_replace('/<@/i', '<?php', $content); // PHP 변환
//		$content = preg_replace('/@>/i', '?>', $content); // PHP 변환
//		$content = preg_replace('/<\#/', "<?=\$", $content); // 변수 변환
//		$content = preg_replace('/\#>/', "?>", $content); // 변수 변환
		return $content;
	}
function compiled($cid,$content){ // 템플릿 컴파일
		$fp=fopen("../data/".$cid."/tpl/".$cid.".tpl.compiled.php","w");
		fwrite($fp,$content);
		fclose($fp);
		chmod("../data/".$cid."/tpl/".$cid.".tpl.compiled.php",0644);
}