<?php
/* Mysql DB 접속 */
$chibi_conn = @mysql_connect($HOSTNAME,$USERNAME,$DBPASSWD); //데이터베이스 접속
@mysql_select_db($DBNAME,$chibi_conn); //데이터베이스 선택
@mysql_query("set names utf8");
$chibi_ver = '1.10.7.1';
?>
