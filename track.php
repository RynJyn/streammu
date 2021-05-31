<?php
session_start();
if ($_SESSION["userid"]=="")
{
header ('Location: login.php');
require 'dbconfig.php';
}
?>

<!doctype html>
<html>
<head>
	<title>stream.mu | Track Info</title>
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
	TRACK INFO
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
				$userid = $_SESSION["userid"];
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
	
	
	<?php
	$trackid = $_GET['trackid'];
	
	if (!$trackid)
		{
		$trackid = 1;
		}
		$sql = "SELECT * FROM tracks WHERE track_id = $trackid limit 1";
		$result = mysql_query($sql);

		if (mysql_num_rows($result) > 0) {
			// output data of each row
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$id = $row["track_id"];
			$name = $row["name"];
			$albumcover = $row["image"];
			$artist = $row["artist"];
			$album = $row["album"];
			$sample = $row["sample"];
			$description = $row["description"];
			}
		} 	
		else 
		{
			echo "0 results";
		}

?>  
	
	<script type="text/javascript">var trackID = <?php echo $id; ?>;</script>
	<div id="songinfo">
	<p class="songtitle"><?= $name ?></p>
	<img class="albumcover" alt="Album Art" src="<?= $albumcover ?>"/>
	<br/>
	<br/>
	<font class="artistname"><?= $artist ?></font>
	<br/>
	<font class="albumname"><?= $album ?></font>
	<br/>
	<font class="albumname"><?= $description ?></font>
	</div>
	<br/>
	<div id="songtasks">
	<table>
		<tr>
			<td class="imgcell"><a href="review.php?trackid=<?=$trackid?>">✰</a></td>
			<td class="textcell"><a href="review.php?trackid=<?=$trackid?>">Review</a></td>
		</tr>
		<tr >
			<td class="imgcell">+</td>
			<td class="textcell"><a href="#playlistselector">Add to Playlist</a>
				<div id="playlistselector">
				
				<?php 
				$sql = "SELECT * FROM playlists WHERE creator = $userid";
				$result = mysql_query($sql);
				if (mysql_num_rows($result) > 0) 
				{
					echo '<form name="Playlist Selection Form" method="post" action="updateplaylist.php?trackid=';
					echo $trackid;
					echo '">';
					echo '<select onchange="this.form.submit()" name="addToPlaylist">';
					echo '<option hidden="hidden" value="">Select a playlist</option>';
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
					{
						$playlistid = $row["playlist_ID"];
						$playlistname = $row["name"];
						echo '<a href="playlist.php?id=';
						echo $playlistid;
						echo '">';
						echo '<option name="playlistid" value=';
						echo $playlistid;
						echo '>';
						echo $playlistname;
						echo '</option>';
						echo '</a>';
					}
					echo '</select>';
					echo '</form>';
				}
				?>
				</div>
			
			</td>
		</tr>
	</table>
	</div>
	<br/>
	<div id="mediacontrols">
		<div id="toplayer">
			<center>
			<button onclick="prev()"><img src="images/previous.png" alt="Previous"/></button>
			<button onclick="playOrPause()"><img id="pic" src="images/play.png" alt="Play"/></button>
			<button onclick="stop()"><img src="images/stop.png" alt="Stop"/></button>
			<button onclick="next()"><img src="images/next.png" alt="Next"/></button>
			</center>
		</div>
	<br/>
	

<audio id="track" src="<?php echo $sample ?>"
       ontimeupdate="playTrack()"></audio>

<div id="bottomlayer">
<span id="tracktime">0:00</span>
<span id="trackduration">0:00</span>
<div>
<div id="progresscontainer">
<div id="progressbar"></div>
</div>
</body>
</html>