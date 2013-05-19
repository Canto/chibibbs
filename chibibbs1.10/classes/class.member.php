<?php
if(!defined("__CHIBI__")) exit();

class member{
	private $user_id; // 멤버 ID
	private $chibi_conn; // DB 접속
	private $permission; // 게시판 권한
	private $member; // 회원정보
	private $cid; // 게시판 ID

	function member_list(){ // 멤버 리스트
		if(empty($this->user_id)==true){
			$sql = "SELECT * FROM `chibi_member` ORDER BY `mno` DESC";
		}else{
			$sql = "SELECT * FROM `chibi_member` WHERE `user_id` = '".mysql_real_escape_string($this->user_id)."'";
		}
		$query = mysql_query($sql,$this->chibi_conn);
		return $query;
	}
	function member(){ // 멤버 정보 
		$sql = "SELECT * FROM `chibi_member` WHERE user_id='".mysql_real_escape_string($this->user_id)."'";
		$query = mysql_query($sql,$this->chibi_conn);
		$this->member = (object) mysql_fetch_array($query);
		return $this->member;
	}
	function bbs_permission(){ // 게시판 권한 체크 
		$array = explode(",",$this->permission);
		$i = 0;
		while($i<count($array)){
			if($array[$i] == $cid || $array[$i] == "all" || $array[$i] == "super" ){ return "true"; }
			$i++;
		}
		return "false";
	}
	function login_ok(){ // 로그인
		$time = time();
		$session = session_id();
		$update = "UPDATE `chibi_member` SET `lastlogin` ='".mysql_real_escape_string($time)."', `session`='".mysql_real_escape_string($session)."' WHERE  user_id='".mysql_real_escape_string($this->user_id)."'";
		mysql_query($update,$this->chibi_conn);
		$chk = mysql_error(); 
		if(empty($chk)==true)return true;
		else return false;
	}

	function logout(){ // 로그아웃
		$time = time();
		$session = session_id();
		$update = "UPDATE `chibi_member` SET `lastlogin` ='".mysql_real_escape_string($time)."', `session`='' WHERE  user_id='".mysql_real_escape_string($this->user_id)."'";
		mysql_query($update,$this->chibi_conn);
		$chk = mysql_error();
		if(empty($chk)==true)return true;
		else return false;
	}

	function login_check(){ // 로그인 체크
		$time = time();
		$session = session_id();
		$sql = "SELECT * FROM `chibi_member` WHERE session='".$session."' ORDER BY `lastlogin` DESC";
		$query = mysql_query($sql,$this->chibi_conn);
		$member_array = mysql_fetch_array($query);
		$this->member = (object) $member_array;
		if(isset($member->lastlogin)){
		if($member->lastlogin == 0  || $time - $member->lastlogin > 10800){
			return false;
		}else{
			$update = "UPDATE `chibi_member` SET `lastlogin` ='".mysql_real_escape_string($time)."' WHERE  session='".mysql_real_escape_string($session)."'";
			mysql_query($update,$this->chibi_conn);
			return true;
		}
		}else{
			return false;
		}
	}
}