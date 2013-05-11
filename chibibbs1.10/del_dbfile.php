<?
header ('Content-type: text/html; charset=UTF-8');
$file = "data/config/db.config.php";
if(is_file($file)){
	unlink($file);
	echo "db 설정 파일 삭제 완료";
}else{
	echo "db 설정 파일 삭제 실패";
}
?>