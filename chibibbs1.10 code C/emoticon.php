<?php
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
$cid = $_GET['cid'];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>이모티콘 리스트</title>
<style>
body {padding:5px;}
.well {padding:5px 0px 5px 0px;}
</style>
</head>
<body>
<div class="span12 well">
<ul id="em_list" class="unstyled inline">
<?php
$string = "SELECT * FROM `chibi_emoticon` where `cid`='".mysql_real_escape_string($cid)."'";
		$em_query = mysql_query($string,$chibi_conn);
		$em_list ='';
		while($em = mysql_fetch_array($em_query)){
		echo "<li style=\"width:80px;height:80px;text-align:center;\">
		<ul class=\"unstyled\">
		<li><img src=\"".$em['url']."\" /></li>
		<li>".$em['inst']."</li>
		</ul>
		</li>";
		}
?>
</ul>
</div>
</body>
</html>