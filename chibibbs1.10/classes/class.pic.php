<?php
if(!defined("__CHIBI__")) exit();

/* 그림 */
class pic{
	private $cid; //게시판 ID
	private $start; //시작할 행
	private $end; //끝낼 행
	private $chibi_conn; //DB 접속
	private $search; //검색옵션 
	private $keyword; // 키워드
	private $op; // WHERE 옵션

	function pic(){ // 그림취득
		if($this->search == "name")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`name`LIKE'".mysql_real_escape_string($this->keyword)."' AND  `chibi_comment`.`cid`='".mysql_real_escape_string($this->cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$this->start.",".$this->end;
		else if($this->search == "comment")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`comment` LIKE '%".mysql_real_escape_string($this->keyword)."%' AND  `chibi_comment`.`cid` =  '".mysql_real_escape_string($this->cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$this->start.",".$this->end;
		else if($this->search == "no")$string = "SELECT * FROM `chibi_pic` WHERE cid='".mysql_real_escape_string($this->cid)."' AND no<='".mysql_real_escape_string($this->keyword)."' ORDER BY `no` DESC LIMIT ".$this->start.",".$this->end;
		else $string = "SELECT * FROM `chibi_pic` where `cid`='".mysql_real_escape_string($this->cid)."' ORDER BY `no` DESC LIMIT ".$this->start.",".$this->end;
		$query = mysql_query($string,$this->chibi_conn);
		$pic_array = mysql_fetch_array($query);
		return $pic_array;
	}
	function news_pic(){ //관리자페이지 그림 취득
		if(empty($this->op)==true){
		$sql = "SELECT * FROM `chibi_pic` WHERE `type`='picture' ORDER BY `idx` DESC LIMIT 0,5";
		}else{
		$sql = "SELECT * FROM `chibi_pic` WHERE `type`='picture' AND ".$this->op." ORDER BY `idx` DESC LIMIT 0,5";
		}
		$query = mysql_query($sql,$this->chibi_conn);
		$news_pic = mysql_fetch_array($query);
		return $news_pic;
	}
}
	

?>