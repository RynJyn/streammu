<?php
$servername = "DB_SERVER";
$username = "DB_USER";
$password = "DB_PASSWORD";
$dbname = "DB_NAME";

mysql_connect("$servername", "$username", "$password")or die("cannot connect"); 

mysql_select_db("$dbname")or die("cannot select DB");
?>
