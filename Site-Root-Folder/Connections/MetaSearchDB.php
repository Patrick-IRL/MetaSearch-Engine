<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_MetaSearchDB = "OMITTED";
$database_MetaSearchDB = "OMITTED";
$username_MetaSearchDB = "OMITTED";
$password_MetaSearchDB = "OMITTED";
$MetaSearchDB = mysql_pconnect($hostname_MetaSearchDB, $username_MetaSearchDB, $password_MetaSearchDB) or trigger_error(mysql_error(),E_USER_ERROR); 
?>