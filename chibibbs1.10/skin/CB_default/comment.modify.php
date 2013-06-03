<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_POST['cid'];
$idx = $_POST['idx'];
$page = $_POST['page'];
/* DB정보취득 */
include_once "../../data/config/db.config.php";
include_once "../../lib/db.conn.php";
include_once "../../lib/bbs.fn.php";
$select = "SELECT * FROM `chibi_comment` WHERE `idx`='".mysql_real_escape_string($_POST['idx'])."'";
$comment_query = mysql_query($select,$chibi_conn);
$comment = mysql_fetch_array($comment_query);
$comment = (object) $comment;
$comment->op = unserialize($comment->op);
$comment->op = (object) $comment->op;
if(get_magic_quotes_gpc()) $comment->comment = stripslashes($comment->comment);
?>
<form method="POST" class="form-horizontal margin0 cmtmodifyForm" action="./lib/comment.modify.ok.php">
<div class="controls-group">
<textarea rows="2" class="span7" id="comment" name="comment" style="resize:none;margin-bottom:3px;" ><?=$comment->comment?></textarea>
</div>
<div class="controls-group">
<p>
<label class="checkbox inline">
<input type="checkbox" id="op['secret']" name="op[secret]" value="secret" <?php if($comment->op->secret=="secret") echo "checked=\"checked\""?>">secret
</label>
<label class="checkbox inline">
<input type="checkbox" id="op['more']" name="op[more]" value="more" <?php if($comment->op->more=="more") echo "checked=\"checked\""?>>more
</label>
</p>
</div>
<div class="controls-group">
<input type="hidden" name="mode" id="mode" value="modify">
<input type="hidden" name="cid" value="<?=$comment->cid?>">
<input type="hidden" id="idx" name="idx" value="<?=$comment->idx?>">
<input type="hidden" id="dice" name="dice" value="<?=$comment->op->dice?>">
<input type="hidden" id="page" name="page" value="<?=$page?>">
<input type="text" class="input-mini" name="name" id="name" placeholder="name" value="<?=$comment->name?>">
<input type="password" class="input-mini" name="passwd" id="passwd" placeholder="password" required>
<button type="submit" class="cmtmodify-submit btn btn-mini btn-info">write</button>
</div>
</form>