<?php
session_start();
if ($_SESSION["userid"]=="")
{
header ('Location: login.php');
}
$userid=$_SESSION["userid"];
require 'dbconfig.php';
$requestedplaylistid = $_GET["id"];
?>

<!doctype html>
<html>
<head>
	<title>stream.mu | Playlist</title>
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" /> 
	<link rel="stylesheet" type="text/css" href="style.css" /> 
	
	<script type="text/javascript" src="js/controls.js"></script> 
	<script type="text/javascript" src="js/obj.js"></script> 
</head>

<body>



	<header>
	<div id="menubutton">
	<button onclick=showMenu()><img src="images/menu.png"/></button>
	<button onclick=goBack()><img src="images/back.png"/></button>
	</div>
	PLAYLIST
	</header>
	<br>
	<nav id="menu">
	<form name="Search Form" method="post" action="search.php" >	
	<input type="text" name="search" size="20" value="">
	</form>
	<ul>
		<a href="home.php"><li class="titleli">Home</li></a>
		<li class="titleli">Browse</li>
			<ul>
				<li>Genre</li>
					<ul>
						<!--Lists all of the available genres in order of A-Z-->
						<?php require 'dbconfig.php';
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
		<a href="logout.php"><li class="titleli">Logout</li></a> <!--Link to provide an easy method of logging out for the user-->
		</ul>
	</nav>
	<br>
	<div id="results">
	<?php 
	$sql = "SELECT * FROM playlists WHERE playlist_ID = $requestedplaylistid";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$tracks = explode(",",$row["tracks"]);
	
	foreach($tracks as $track){
		
	
$sql = "SELECT * FROM tracks WHERE track_id = $track";
$result = mysql_query($sql);

if (mysql_num_rows($result) > 0) {
     // output data of each row
     while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$id = $row["track_id"];
	$name = $row["name"];
	$artist = $row["artist"];
	$album = $row["album"];
	$sample = $row["sample"];
	$albumart = $row["thumb"];
	echo '<div class="searchresult">';
	echo '<a href="track.php?trackid=';
	echo $row["track_id"];
	echo '">';
	echo '<img alt="Album Art" src=';
	echo $albumart;
	echo '>';
	echo '<br>';
	echo '<font>';
	echo $name;
	echo '</font>';
	echo '<br>';
	echo $artist;
	echo '<br>';
	echo '</a>';
	echo $album;
	echo '</div>';
     }
} else{
	echo '<p class="noresult">';
     echo "0 results found for ";
	echo $search;
	echo '</p>';
}
	}
	}
?>  
	</div>
	
	
</body>
</html>