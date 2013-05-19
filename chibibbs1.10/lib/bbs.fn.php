<?php
if(!defined("__CHIBI__")) exit();
/* 
파일 관련 함수
*/
	function make_tpl($skin,$cid){
		$tpl = fopen("../skin/".$skin."/layout.php", "r");
		$tpl_file = '';
		while (!feof($tpl)){
		$tpl_file = $tpl_file.fgets($tpl);
		}
		$fp=fopen("../data/tpl/".$cid.".tpl.php","w");
		fwrite($fp,$tpl_file);
		fclose($fp);
		fclose($tpl);
		chmod("../data/tpl/".$cid.".tpl.php",0644);
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
		  if(is_file($file)) unlink($file); // delete file
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
?>