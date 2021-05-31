<?php
session_start();
if ($_SESSION["userid"]=="")
{
header ('Location: login.php');
}
require 'dbconfig.php';
?>

<!doctype html>
<html>
<head>
	<title>stream.mu | Home</title>
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	
	<script type="text/javascript" src="js/controls.js"></script>
	<script type="text/javascript" src="js/obj.js"></script>
</head>

<body>
	<?php 
	$userid = $_SESSION["userid"];
	$sql = "SELECT username FROM login WHERE id = $userid limit 1";
	$result = mysql_query($sql);
if (mysql_num_rows($result) > 0) {
     // output data of each row
     while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$user = $row["username"];
     }
}
	?>
	<header>
	<div id="menubutton">
	<button onclick=showMenu()><img src="images/menu.png"/></button>
	</div>
	Hi, <?= $user ?>
	</header>
	<br>
	<nav id="menu">
	<p>Enter a search term:</p>
	<form name="Search Form" method="post" action="search.php" >	
	<input type="text" name="search" size="20" value="">
	</form>
	<ul>
		<a href="index.php"><li class="titleli">Home</li></a>
		<li class="titleli">Browse</li>
			<ul>
				<li>Genre</li>
					<ul>
						<?php
						$sql = "SELECT DISTINCT(genre) FROM tracks ORDER BY genre ASC";
						$result = mysql_query($sql);
						if (mysql_num_rows($result) > 0) 
						{
						while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
						{
						$genre = $row["genre"];
						echo '<a href=genre.php?genre=';
						echo urlencode($genre); //Enables use of spaces when passing a variable in a URL
						echo '>';
						echo '<li>';
						echo $genre;
						echo '</li>';
						echo '</a>';
	}
	} ?>
					</ul>
				<a href="tracks.php"><li>All Tracks</li></a>
			</ul>
		<a href="offers.php"><li class="titleli">Offers</li></a>
		<li class="titleli">Playlists</li>
			<ul>
				<?php 
				$sql = "SELECT * FROM playlists WHERE creator = $userid";
				$result = mysql_query($sql);
				if (mysql_num_rows($result) > 0) 
				{
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$playlistname = $row["name"];
					$playlistid = $row["playlist_ID"];
					echo '<a href="playlist.php?id=';
					echo $playlistid;
					echo '">';
					echo '<li>';
					echo $playlistname;
					echo '</li>';
					echo '</a>';
				}
				}
				else
				{
					echo '<li>You do not own any playlists</li>';
				}
				?>
			</ul>
		<a href="logout.php"><li class="titleli">Logout</li></a>
		</ul>
	</nav>

<div id="randomtrack">
<br>
<h3>Why not try...</h3>
<?
	$sql = "SELECT * FROM tracks ORDER BY RAND() limit 1"; //Selects a single track from the database at random
	$result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
     // output data of each row
     while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$name = $row["name"];
	$albumcover = $row["thumb"];
	$artist = $row["artist"];
	$album = $row["album"];
	echo '<div id="trackinfo">';
	echo '<a href="track.php?trackid=';
	echo $row["track_id"];
	echo '">';
	echo '<img class="albumcover" alt="Album Art" src=';
	echo $row["image"];
	echo '>';
	echo '<br>';
	echo '<br>';
	echo $name;
	echo '<br>';
	echo $artist;
	echo '<br>';
	echo $album;
	echo '</a>';
	echo '</div>';
     }
}
?>
</body>
</html>