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

	$sql = "select * from `chibi_member` where `user_id`='".mysqli_real_escape_string($chibi_conn, $user_id)."'";
	$result = mysqli_query($chibi_conn, $sql);
	$array = mysqli_fetch_array($result);

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

	mysqli_close($chibi_conn);
}
?>