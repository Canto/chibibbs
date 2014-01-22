<?php
class paging{
	//--default obj--//
	private $page;					// 현재 페이지
	private $list;					// 화면에 보여질 게시물 갯수
	private $block;					// 하단에 보여질 페이징 갯수 블럭단위 [1]~[5]
	private $limit;					// 게시물 가져올 스타트 페이지
	private $total_row;				// 전체 게시물 row 수
	
	private $total_page;			// 전체 페이지 수
	private $total_block;			// 전체 블럭 갯수
	private $now_block;				// 현재 블럭
	private $start_page;			// 블럭 이동시 스타트 지점 객체
	private $end_page;				// 블럭의 끝 페이지
	private $is_next = false;		// 다음 페이지 이동을 위한 객체
	private $is_prev = false;		// 이전 페이지 이동을 위한 객체
	
	//--display(style) obj--//
	private $next_btn	= "&raquo;";	// default 다음 이동 버튼
	private $prev_btn	= "&laquo;";	// default 이전 이동 버튼
	private $end_btn	= "마지막";	// default 끝 이동 버튼
	private $start_btn	= "처음";	// default 처음 이동 버튼
	private $display_class;			// <a 태그내의 class를 지정할 때
	private $display_id;			// <a 태그내의 id를 지정할 때
	private $display_mode = false;	// 기본 디스플레이 => [1]234 [다음], 풀모드=> [처음][이전][1]234[다음][끝]
	private $display_confirm = false;	// setDisplay 메서드 호출 확인값
	
	//--etc obj--/
	private $url_confirm = false;	// setUrl 메서드 호출 확인값
	private $html;					// 최종 결과물 리턴 객체

	
	public function paging($page=1, $list=10, $block=10, $total_row=0){	// --default init setting

		if(!$page)	$this->page = 1;
		else		$this->page = $page;
		$this->list = $list;
		$this->block = $block;
		$this->total_row = $total_row;
		$this->limit = ($this->page - 1) * $this->list;
		$this->url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] . "?";
		$this->setAuto();
		
	}
	
	public function getVar($name){

		if(gettype($this->$name) == "NULL"){
			echo "<script type=\"text/javascript\">alert('" . $name . " 객체는 없습니다.\\n얻고자 하시는 객체명을 확인해주세요.');</script>";
			return;
		}
		else	return $this->$name;
	
	}
	
	/* 사용하는 유저가 어쩔수 없이 객체의 값을 직접적으로 바꿔줘야 할 경우..
	public function setVar($name, $val){
		
		if(!is_numeric($val)){
			echo "<script type=\"text/javascript\">alert('setVar()메서드는 숫자만 허용합니다.');</script>";
			return;
		}
		else	$this->$name = $val;
		
	}*/

	private function setAuto(){
		
		$this->total_page = ceil($this->total_row / $this->list);
		$this->total_block = ceil($this->total_page / $this->block);
		$this->now_block = ceil($this->page / $this->block);
		
		$this->start_page = ($this->now_block - 1) * $this->block + 1;
		$this->end_page = $this->start_page + $this->block - 1;
		
		if($this->end_page > $this->total_page) $this->end_page = $this->total_page;
		if($this->now_block < $this->total_block) { $this->is_next = true; }
		if($this->now_block > 1) { $this->is_prev = true; }
		
	}
	
	public function setUrl($get=false){
		
		if($get){
			
			$this->url = $this->url . $get ."&";
			$this->url_confirm = true;
			
		}
		else{
			
			echo "<script type=\"text/javascript\">alert('unknown error!!');</script>";
			
		}
		
	}
	
	public function setDisplay($name, $val=false){
		
		if($this->display_confirm == true){
			
			echo "<script type=\"text/javascript\">alert('setDisplay 메서드는 showPage 메서드 이전에 셋팅하셔야 합니다.');</script>";
			return;
			
		}
		switch($name){
			
			case "full"		:	$this->display_mode = true;
			break;
			
			case "class"	:	$this->display_class = " class=\"{$val}\"";
			break;
			
			case "id"		:	$this->display_id = " id=\"{$val}\"";
			break;
			
			case "next_btn"	:	$this->next_btn = $val;
			break;
			
			case "prev_btn"	:	$this->prev_btn = $val;
			break;
			
			case "end_btn"	:	$this->end_btn = $val;
			break;
			
			case "start_btn"	:	$this->start_btn = $val;
			break;	
					
			default :	echo "<script type=\"text/javascript\">alert('[$name] is undefined Object!!');</script>";
			break;
			
		}
		
	}

	public function showPage(){
		
		//이 메서드를 호출하는 순간 setting은 할 수 없게 만듬
		$this->url_confirm = true;
		$this->display_confirm = true;

		if($this->display_mode && ($this->page != 1)){
			$this->html =  "<li><span><a href=\"http://{$this->url}page=1\">{$this->start_btn}</a></span></li>";	
		}
		if($this->is_prev){
			$go_prev = $this->start_page - 1;
			$this->html .=  "<li><span><a href=\"http://{$this->url}page=$go_prev\">{$this->prev_btn}</a></span></li>";
		}
		
		for($i = $this->start_page; $i <= $this->end_page; $i++){
			if($i == $this->page)	$this->html .= "<li class=\"active\"><span>$i</span></li>";
			else					$this->html .= "<li><a href=\"http://{$this->url}page=$i\"{$this->display_class}{$this->display_id}>{$i}</a></li>";
		}
		
		if($this->is_next){ 
			$go_next = $this->start_page + $this->block;
        	$this->html .= "<li><a href=\"http://{$this->url}page=$go_next\">{$this->next_btn}</a></li>";
    	}
    	if($this->display_mode && ($this->page != $this->total_page)){
        	$this->html .= "<li><a href=\"http://{$this->url}page=$this->total_page\">{$this->end_btn}</a></li>";
    	}
    	
    	return $this->html;
	}

}
?>