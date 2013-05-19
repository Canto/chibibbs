<?php
class tpl{
	
	private $cid;
	private $skin;
	private $content;
	
	private function load(){ //템플릿 파일 로드
		if(!ob_start("ob_gzhandler")) ob_start();
		include_once "../data/".$this->cid."/".$this->cid.".tpl.php";
		$this->content = ob_get_contents();
		ob_end_clean();
	}
	private function compiled(){ // 템플릿 컴파일
		

	}
	private function convert(){ // 템플릿 변수를 PHP변수로 컴파일


	}
}


?>