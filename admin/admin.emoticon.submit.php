<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$inst = $_POST['inst'];
$cid = $_POST['cid'];

/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";
if($inst && $_FILES){
$file=$_FILES['image']['name'];
$filename = time();
$path = '../data/'.$cid.'/emoticon/';
$ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));

if ($ext == ".jpeg" || $ext == ".JPEG" || $ext == ".jpg" || $ext == ".JPG" || $ext == ".gif" || $ext == ".GIF" || $ext == ".PNG" || $ext == ".png") {
      move_uploaded_file($_FILES["image"]["tmp_name"], $path.$filename.$ext);
	  $url = 'data/'.$cid.'/emoticon/'.$filename.$ext;
	  $query = "INSERT INTO `chibi_emoticon` (`cid`,`inst`,`url`)VALUES('".mysql_real_escape_string($cid)."','".mysql_real_escape_string($inst)."','".mysql_real_escape_string($url)."')";
	  mysql_query($query,$chibi_conn);	  
		$chk = true;
		echo $chk;
}else{
	$chk = false;
	echo $chk;
}
mysql_close($chibi_conn);
}
?>