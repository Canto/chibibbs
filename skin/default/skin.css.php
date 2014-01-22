<?php
/*유저 설정 css */
if(!empty($skin->op->link_color)){
	echo "
	a:link { text-decoration: none !important; color: ".$skin->op->link_color." !important; }\n
	a:visited { text-decoration: none !important; color: ".$skin->op->link_color." !important;}\n
	a:active { text-decoration: none !important; color: ".$skin->op->link_color." !important;}\n
	";
}
if(!empty($skin->op->hover_color)) echo "a:hover { text-decoration: none !important; color: ".$skin->op->hover_color." !important;}\n";
if(!empty($skin->op->background_color)) echo "body{background-color:".$skin->op->background_color." !important;}\n";
if(!empty($skin->op->background_img)) echo "body{background-image:url('".$skin->op->background_img."');}\n";
if(!empty($skin->op->repeat)){
	if($skin->op->repeat == "fixed")
		echo "body {background-repeat:no-repeat; background-attachment:fixed}";
	else 
		echo "body {background-repeat:".$skin->op->repeat.";}\n";
}
if(!empty($skin->op->notice_border_color)) echo ".user_notice_border_color {border:".$skin->op->notice_border_color." !important;}\n";
if(!empty($skin->op->notice_border_type)) echo ".user_notice_border_type {border-style:".$skin->op->notice_border_type." !important;}\n";
if(!empty($skin->op->notice_background_color)) echo ".user_notice_background_color {background-color:".$skin->op->notice_background_color." !important;}\n";
if(!empty($skin->op->notice_font_color)) echo ".user_notice_background_color {color:".$skin->op->notice_font_color." !important; text-shadow:0 0px 0 rgba(255, 255, 255, 0.5) !important;}\n";
if(!empty($skin->op->table_border_size)) echo ".user_table_border_size {border:".$skin->op->table_border_size." !important;}\n";
if(!empty($skin->op->table_border_type)) echo ".user_table_border_type {border-style:".$skin->op->table_border_type." !important;}\n";
if(!empty($skin->op->table_border_color)) echo ".user_table_border_color {border-color:".$skin->op->table_border_color." !important; -webkit-box-shadow:inset 0px 0px 0px 0px rgba(0, 0, 0, 0) !important;-moz-box-shadow:inset 0px 0px 0px 0px rgba(0, 0, 0, 0) !important;box-shadow:inset 0px 0px 0px 0px rgba(0, 0, 0, 0) !important;}\n";
if(!empty($skin->op->table_border_size) || !empty($skin->op->table_border_type) || !empty($skin->op->table_border_color)) echo ".log th,td{border-left:0px !important;}";
if(!empty($skin->op->table_inner_border_size)) echo ".user_table_inner_border_top_size {border-top:".$skin->op->table_inner_border_size." !important;}\n";
if(!empty($skin->op->table_inner_border_size)) echo ".user_table_inner_border_left_size {border-left:".$skin->op->table_inner_border_size." !important;}\n";
if(!empty($skin->op->table_inner_border_type)) echo ".user_table_inner_border_top_type {border-top-style:".$skin->op->table_inner_border_type." !important;}\n";
if(!empty($skin->op->table_inner_border_type)) echo ".user_table_inner_border_left_type {border-left-style:".$skin->op->table_inner_border_type." !important;}\n";
if(!empty($skin->op->table_inner_border_color)) echo ".user_table_inner_border_color {border-color:".$skin->op->table_inner_border_color." !important; -webkit-box-shadow:inset 0px 0px 0px 0px rgba(0, 0, 0, 0) !important;-moz-box-shadow:inset 0px 0px 0px 0px rgba(0, 0, 0, 0) !important;box-shadow:inset 0px 0px 0px 0px rgba(0, 0, 0, 0) !important;}\n";
if(!empty($skin->op->table_background_color)) echo ".user_table_background_color {background-color:".$skin->op->table_background_color." !important;}\n";
if(!empty($skin->op->pic_background_color)) echo ".user_pic_background_color {background-color:".$skin->op->pic_background_color." !important;}\n";
if(!empty($skin->op->reply_background_color)) echo ".user_reply_background_color {background-color:".$skin->op->reply_background_color." !important;}\n";
if(!empty($skin->op->reply_text_color)) echo ".user_reply_text_color {color:".$skin->op->reply_text_color." !important;}\n";
if(!empty($skin->op->rereply_bar_color)) echo ".user_rereply_bar_color {border-left:5px solid ".$skin->op->rereply_bar_color." !important;}\n";
if(!empty($skin->op->rereply_text_color)) echo ".user_rereply_text_color {color:".$skin->op->rereply_text_color." !important;}\n";
if(!empty($skin->op->top_menu_icon_color)) echo ".label, .label-info, .badge-info, .more {background-color:".$skin->op->top_menu_icon_color." !important;}\n"
?>