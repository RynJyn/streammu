<?php
session_start();
$user=$_POST["user"];
$pass=$_POST["password"];
include("dbconfig.php");
$sql="SELECT * FROM login";
$result=mysql_query($sql);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
{
if(strtolower($user)==strtolower($row["username"]) && $pass==$row["password"])
{
$_SESSION["userid"]=$row["id"];
header ('Location: home.php'); 
}
}
if ($_SESSION["userid"]=="")
{
header ('Location: login.php?m=incorrect');
//User is returned to the login page if either the username or password is wrong, and is shown an error.
}


?>