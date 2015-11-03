<?php
/* Mysql DB 접속 */
$chibi_conn = @mysqli_connect($HOSTNAME,$USERNAME,$DBPASSWD); //데이터베이스 접속
@mysqli_select_db($chibi_conn, $DBNAME); //데이터베이스 선택
@mysqli_query($chibi_conn, "set names utf8");
$chibi_ver = '1.10.8.2';
?>
