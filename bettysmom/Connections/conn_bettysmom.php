<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);//顯示錯誤訊息的型別
date_default_timezone_set('Asia/Taipei');//設定台北時區
$hostname_conn_bettysmom = "localhost";
$database_conn_bettysmom = "bettysmom";
$username_conn_bettysmom = "root";
$password_conn_bettysmom = "";
$conn_bettysmom = mysql_pconnect($hostname_conn_bettysmom, $username_conn_bettysmom, $password_conn_bettysmom) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8'",$conn_bettysmom);//解決顯示中文成亂碼的問題
?>