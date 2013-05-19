<?php
if(!defined("__CHIBI__")) exit();

class comment{
	private $chibi_conn; //DB 접속
	private $op; // WHERE 옵션
	private $cid; // 게시판 ID
	private $pic_no; // 그림 번호

	function news_comment(){
		if(empty($this->op)==true){
		$sql = "SELECT * FROM `chibi_comment` ORDER BY `idx` DESC LIMIT 0,5";
		}else{
		$sql = "SELECT * FROM `chibi_comment` WHERE ".$this->op." ORDER BY `idx` DESC LIMIT 0,5";
		}
		$query = mysql_query($sql,$this->chibi_conn);
		$comment = mysql_fetch_array($query);
		return $query;
	}
	function comment(){
		$string = "SELECT * FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($this->cid)."' AND `pic_no`='".mysql_real_escape_string($this->pic_no)."' 
ORDER BY `no` ASC , `depth` ASC, `rtime` ASC";
		$query = mysql_query($string,$this->chibi_conn);
		$comment = mysql_fetch_array($query);
		return $query;
	}
}