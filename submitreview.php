<?php 

$trackid = $_GET["trackid"]; 
$name = $_POST["username"]; 
$review = $_POST["review"]; 
$rating = $_POST["rating"]; 
$complete = false; 

require 'dbconfig.php';

$sql="INSERT INTO reviews (`review_id`,`product_id`,`name`,`review`,`rating`) VALUES ('NULL','$trackid','$name','$review','$rating')";
//Inserts a new row into the reviews table with the provided data
$result = mysql_query($sql) or die(mysql_error());
if ($result)
{
	$complete = true;
		if ($complete == true)
		{
			echo '<script>alert("Your review has successfully been added");'; //Issues an alert to show the operation was successful
			echo 'document.location = "track.php?trackid='; //Returns the user to the track page they were originally on
			echo $trackid;
			echo '";';
			echo '</script>';
		}
}
else
{
	//do nothing
}
?>