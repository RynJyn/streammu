<?php
if(isSet($_GET["m"]))
{
	$message = $_GET["m"]; 
}
?>

<!doctype html>
<html>
<head>
<meta name="mobile-web-app-capable" content="yes"> 
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="stylesheet" type="text/css" href="style.css" /> 

<title>stream.mu | Login</title>
</head>
<body>

<header>LOGIN</header>
<br>
<br>

<form name="loginform" method="post" action="check-login.php" > 
<p>Enter your login details and click 'login':</p>
<p>Username: <br>
<input type="text" name="user" size="20" value="" required>
</p>
<p>Password: <br>
<input type="password" name="password" size="20" value="" required>
</p>
<p><input type="submit" name="Submit" value=" Login &gt;&gt; ">
</p>


<?php
if (isSet($message))
{
	if ($message == 'incorrect')
	{
		echo '<font id="loginerror">Username or Password incorrect.</font>'; //If the message 'incorrect' exists, show what was wrong with the previous form submission
	}
	if ($message == 'logout')
	{
		echo '<script>alert("You have successfully logged out");'; //If the message 'logout' exists, alert the user of a successful logout and remove the ?m= extension in the URL
		echo 'document.location="login.php";';
		echo '</script>';
	}
}
?>
</form>

</body>
</html>