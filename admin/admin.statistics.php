<?php
if(!defined("__CHIBI__")) exit();


if($member->permission=="super" || $member->permission=="all"){

function cnt($sql,$chibi_conn){
$query = mysql_query($sql,$chibi_conn);
$row = mysql_fetch_row($query);
return $row[0];
}

$y = date('Y');
$m = date('m');
$d = date('d');
$total = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y)."%'";
$total = cnt($total,$chibi_conn);
$total_m = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."%'";
$total_m = cnt($total_m,$chibi_conn);
$total_w = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."__'";
$total_w = cnt($total_w,$chibi_conn);
?>
<table id="board-create" class="table table-bordered" style="margin:auto;width:90%;">
<tbody>
<tr >
<td class="td-left ">
<p><b>월별 방문자수 : <?=$y?>년 총 <?=$total?> 명 방문</b></p>
</td>
</tr>
<tr >
<td>
<?php
for($i=1;$i<13;$i++){
$m_i = sprintf('%02d',$i);
$month = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m_i)."%'";
$month = cnt($month,$chibi_conn);
$month_g = round($month/$total*100,0);
?>
<?=$i?> 월 : <?php if($month) echo "총 ".$month."명 방문(".$month_g."%)";?>
<div class="progress progress-info inline">
<div class="bar" style="width:<?=$month_g?>%"></div>
</div>
<?php
}
?>
</td>
</tr>
<tr>
<td class="td-left">
<p><b>일별 방문자수 : <?=date('n')?>월 총 <?=$total_m?> 명 방문</b></p>
</td>
</tr>
<tr>
<td>
<?php
for($i=1;$i<date('t')+1;$i++){
$d_i = sprintf('%02d',$i);
$day = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m).mysql_real_escape_string($d_i)."%'";
$day = cnt($day,$chibi_conn);
$day_g = round($day/$total_m*100,0);
?>
<?=$i?> 일 : <?php if($day) echo "총 ".$day."명 방문(".$day_g."%)";?>
<div class="progress progress-info">
<div class="bar" style="width:<?=$day_g?>%"></div>
</div>

<?php
}
?>
</td>
</tr>
<tr>
<td class="td-left">
<p><b>요일별 방문자수 : <?=date('n')?>월 총 <?=$total_m?> 명 방문</b></p>
</td>
</tr>
<tr >
<td>
<?php
for($i=1;$i<8;$i++){
switch($i){
	case 1 : 
		$dw = "Mon";
		break;
	case 2 :
		$dw = "Tue";
		break;
	case 3 :
		$dw = "Wed";
		break;
	case 4 :
		$dw = "Thu";
		break;
	case 5 :
		$dw = "Fri";
		break;
	case 6 :
		$dw = "Sat";
		break;
	default :
		$dw = "Sun";
		break;
}

$w_day = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."%".mysql_real_escape_string($dw)."'";
$w_day = cnt($w_day,$chibi_conn);
$w_day_g = round($w_day/$total*100,0);
?>
<?=$dw?>: <?php if($w_day) echo "총 ".$w_day."명 방문(".$w_day_g."%)";?>
<div class="progress progress-info">
<div class="bar" style="width:<?=$w_day_g?>%"></div>
</div>

<?php
}
?>
</td>
</tr>
<tr>
<td class="td-left">
<p><b>시간별 방문자수 : <?=date('n')?>월 총 <?=$total_m?> 명 방문</b></p>
</td>
</tr>
<tr>
<td>
<?php
for($i=1;$i<25;$i++){
$t_i = sprintf('%02d',$i);
$time = "SELECT count(*) FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."__".mysql_real_escape_string($t_i)."%'";
$time = cnt($time,$chibi_conn);
$time_g = round($time/$total_m*100,0);
?>
<?=$i?> 시 : <?php if($time) echo "총 ".$time."명 방문(".$time_g."%)";?>
<div class="progress progress-info">
<div class="bar" style="width:<?=$time_g?>%"></div>
</div>

<?php
}
?>
</td>
</tr>
<?php
$m_device_sql = "SELECT * FROM `chibi_log` where  date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."%'";
$m_device_query = mysql_query($m_device_sql,$chibi_conn);
while($m_device_array = mysql_fetch_array($m_device_query)){
	$m_device = unserialize($m_device_array['op']);
	$c_device[] = $m_device['device'];
	$browser[] = $m_device['browser'];
}
$k_device = @array_count_values($c_device);
$k_browser = @array_count_values($browser);

?>
<tr>
<td class="td-left">
<p><b>접속 환경 : <?=date('n')?>월 총 <?=$total_m?> 명 방문</b></p>
</td>
</tr>
<tr>
<td>
<?php
arsort($k_device);
if(count($k_device)<10)$max = count($k_device);
else $max = 10;
for($i=0;$i<$max;$i++){
$device_g = round($k_device[key($k_device)]/$total_m*100,0);
$device_sum = $device_sum + $k_device[key($k_device)];
if($i==9){
?>
기타 : 총 <?=$total_m-$device_sum?>명 방문(<?=round(($total_m-$device_sum)/$total_m*100,0)?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=round(($total_m-$device_sum)/$total_m*100,0)?>%"></div>
</div>
<?php
}else{
?>
<?=key($k_device)?> : 총 <?=$k_device[key($k_device)]?>명 방문(<?=$device_g?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=$device_g?>%"></div>
</div>
<?php
}
next($k_device);
}
?>
</td>
</tr>
<tr>
<td class="td-left">
<p><b>접속 브라우져 : <?=date('n')?>월 총 <?=$total_m?> 명 방문</b></p>
</td>
</tr>
<tr>
<td>
<?php
arsort($k_browser);
if(count($k_browser)<10)$max = count($k_browser);
else $max = 10;
for($i=0;$i<$max;$i++){
$browser_g = round($k_browser[key($k_browser)]/$total_m*100,0);
$browser_sum = $browser_sum + $k_browser[key($k_browser)];
//print_r($k_device_sort);
if($i==9){
?>
기타 : 총 <?=$total_m-$browser_sum?>명 방문(<?=round(($total_m-$browser_sum)/$total_m*100,0)?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=round(($total_m-$browser_sum)/$total_m*100,0)?>%"></div>
</div>
<?php
}else{
?>
<?=key($k_browser)?> : 총 <?=$k_browser[key($k_browser)]?>명 방문(<?=$browser_g?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=$browser_g?>%"></div>
</div>
<?php
}
next($k_browser);
}
?>
</td>
</tr>

</tbody>
</table>
<br/>
<?php
}else{
?>

<div class="span6 offset3 alert alert-error margin20">
<a class="close" href="javascript:history.go(-1);">&times;</a>
접속권한이 없습니다.<br/>
해당 게시판 관리자만 접속 가능한 페이지 입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
?>