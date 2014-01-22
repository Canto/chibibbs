<?php
class Template {

   public $template;

   function load($filepath) {
   }

   function replace($var, $content) {
	  preg_replace('/{#(.+)#}/i', '/<?=$\\1[\\2]?>', $this->template);
   }

   function publish() {

   }

}
?>