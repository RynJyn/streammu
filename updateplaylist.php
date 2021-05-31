<?php
session_start();
if ($_SESSION["userid"]=="")
{
header ('Location: login.php');
}

$playlistid = $_POST["addToPlaylist"]; //Obtains the playlist ID from the addToPlaylist form in track.php
$trackid = $_GET["trackid"];
$complete = false;

require 'dbconfig.php';
$sql = "UPDATE  playlists SET tracks =  Concat(tracks, ',' , $trackid) WHERE  playlist_ID =$playlistid;";
//Updates the tracks field of a certain playlist to include a comma plus the id of a track to add to the playlist
$result = mysql_query($sql);
$complete = true;
if ($complete == true)
{
	echo '<script>alert("Track successfully added to the playlist");'; //Used to show a pop up to notify the user of the successful operation
	echo 'document.location = "playlist.php?id='; //Sends the user to their chosen playlist
	echo $playlistid;
	echo '";';
	echo '</script>';
}
				
?>
