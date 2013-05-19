<?php
if(!defined("__CHIBI__")) exit();
/* 
게시판 접속 & 설정 클래스
*/
class bbs{
	private $chibi_conn; // DB 접속
	private $cid; //게시판ID
	private $op; //카운터용 옵션
	private $table; //테이블 정보
	private $db = (object) array("status"=>"","admin"=>"","skin"=>"","pic"=>"","comment"=>"","tpl"=>"","member"=>"","emoticon"=>"","log"=>""); // 설치정보 체크
	

	function select($cid,$chibi_conn){ /* 게시판 선택 */
		if(empty($cid)==true){
		$string = "SELECT * FROM `chibi_admin`";
		}else{
		$string = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($cid)."'";
		}
		$query = mysql_query($string,$chibi_conn);
		$select_array = (object) mysql_fetch_array($query);
		return $select_array;
	}
	function select_skin($cid,$chibi_conn){ /* 게시판 선택 */
		$string = "SELECT * FROM `chibi_skin` where `cid`='".mysql_real_escape_string($cid)."'";
		$query = mysql_query($string,$chibi_conn);
		$select_skin_array = (object) mysql_fetch_array($query);
		return $select_skin_array;
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
	function count_up(){
		$session = session_id();
		$date = date("Ymd");
		if(empty($this->cid)==false){
			$chk_sql = "SELECT * FROM `chibi_log` where `cid`='".mysql_real_escape_string($this->cid)."' AND `ip`='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' AND `date`='".mysql_real_escape_string($date)."'";
			$chk_query = mysql_query($chk_sql,$this->chibi_conn);
			$chk = (object) mysql_fetch_array($chk_query);
			if(empty($chk->cid)==true){
				$sql = "INSERT INTO `chibi_log` (`cid` ,`ip` ,`session` ,`date`)VALUES ('".mysql_real_escape_string($this->cid)."',  '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."',  '".mysql_real_escape_string($session)."',  '".mysql_real_escape_string($date)."')";
				$query = mysql_query($sql,$this->chibi_conn);
				return $query;
			}
		}
	}
}
