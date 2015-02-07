<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$user_id = $_POST['user_id'];
/* DB정보취득 */
include_once "../data/config/db.config.php";
include_once "../lib/db.conn.php";

if($user_id)
{

	$sql = "select * from `chibi_member` where `user_id`='".mysql_real_escape_string($user_id)."'";
	$result = mysql_query($sql,$chibi_conn);
	$array = mysql_fetch_array($result);

	if(empty($array['user_id']))
	{
		$chk = true;
		echo $chk;
	}
	else
	{
		$chk = false;
		echo $chk;
	}

	mysql_close($chibi_conn);
}
?>