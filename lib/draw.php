<?php
if(!defined("__CHIBI__")) exit();

if($cAct == "picContinue"){

	if(empty($_POST['chi_idx'])==false){

		$chi_idx = $_POST['chi_idx'];
		$continue_passwd = $_POST['continue_passwd'];
		$sql = "SELECT * FROM `chibi_pic` WHERE  `idx`='".mysql_real_escape_string($chi_idx)."'";
		$query = mysql_query($sql,$chibi_conn);
		$array = mysql_fetch_array($query);
		if($array['passwd']==md5($_POST['continue_passwd'])){

			$chi_file = $array['src'];
			$cn_file = explode(".",$chi_file);
			$size = GetImageSize($array['src']);
			$width = $size[0];
			$height = $size[1];
		}else{
			echo "<script>
			alert('패스워드가 틀렸습니다.');
			history.go(-1);
			</script>";
			exit;
		}
	}else{
		$chi_file = '';
		$cn_file = array('');
	}
}
if(empty($_POST['chi_idx'])==true){
$chi_file = '';
$cn_file = array('');
}
if(empty($_POST['height'])==false){
	$height = $_POST['height'];
}
if(empty($_POST['width'])==false){
	$width = $_POST['width'];
}
if(empty($_POST['tool'])==false){
	$tool = $_POST['tool'];
}else{
	$tool = "chibi";
}
if(empty($member->user_id)==false){
	$user_id = $member->user_id;
}else{
	$user_id = '';
}
$passwd='';

/* IP 체크 */
if($bbs->spam->op == "ban" || $bbs->spam->op == "write"){
		ip_check($bbs->spam->ip); /* IP 체크 함수*/
}


if($width>$bbs->op->pic_max_width || $width<$bbs->op->pic_min_width){
	echo "<script>
	alert('그림의 너비는 ".$bbs->op->pic_min_width." - ".$bbs->op->pic_max_width." 로 지정하시기 바랍니다.');
	history.go(-1);
	</script>";
}
if($height>$bbs->op->pic_max_height || $height<$bbs->op->pic_min_height){
	echo "<script>
	alert('그림의 높이는 ".$bbs->op->pic_min_height." - ".$bbs->op->pic_max_height." 로 지정하시기 바랍니다.');
	history.go(-1);
	</script>";
}

   $set_time = time();
   $canvas = $height+300;
  

if($tool == "chibi"){
		$set_tool = "<applet archive=\"chibipaint.jar\" code=\"chibipaint.ChibiPaint.class\" width=\"100%\" height=\"".$canvas."\">
      <param name=\"canvasWidth\" value=\"".$width."\" />
      <param name=\"canvasHeight\" value=\"".$height."\" />
      <param name=\"postUrl\" value=\"lib/chipost.php?cid=".$cid."&set_time=".$set_time."&user_id=".$user_id."\" />
      <param name=\"exitUrl\" value=\"index.php?cid=".$cid."\" />
      <param name=\"exitUrlTarget\" value=\"_self\" />
      <param name=\"loadImage\" value=\"".$chi_file."\" />
      <param name=\"loadChibiFile\" value=\"".$cn_file[0].".chi\" />
    </applet>";
}else{
$cwidth = $width+300;
$set_tool="<form name=\"fo_post\">
<object width='".$cwidth."' height='".$canvas."' classid='clsid:C89BAC33-28B7-4297-AC5B-2BA81E275F91' id='btoolcontrol'
CODEBASE = 'http://btool.net/download/btool2011.cab#version=1,2,1,3'>
<param name='uploadurl' value='lib/post.php?cid=".$cid."&set_time=".$set_time."&user_id=".$user_id."'>
<param name='writeurl' value='write.php?id=test'>
<param name='picw' value='".$width."'>
<param name='pich' value='".$height."'>
<param name='EnhancedOptions' value='TransparentBrush,Continue,BToolBBS,UseLoader,UseTypeTool,JPGUncheck'>
</object>
</form>
";
}
   include_once "skin/".$bbs->skin."/draw.php";
?>