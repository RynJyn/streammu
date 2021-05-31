<?php
session_start();
if ($_SESSION["userid"]=="")
{
header ('Location: login.php');
}
require 'dbconfig.php';
$trackid = $_GET["trackid"];
?>

<!doctype html>
<html>
<head>
	<title>stream.mu | Review</title>
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
	REVIEW TRACK
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
				<!--Lists all of the playlists owned by a user-->
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
	
	<br>
	<br>
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
	
	<form name="reviewform" method="post" action="submitreview.php?trackid=<?=$trackid?>">
	<p>Submit your review using the form below:</p>
	<p>Username: </p>
	<input type="text" name="username" value="<?=$user?>">
	<p>Your Review </p>
	<input type="text" name="review" value="">
	<p>Rating: </p>
	<select name="rating">
	<option value="0">0</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	</select>
	<p></p>
	<input type="submit" name="submit" value="Submit">
	</form>
	
</body>
</html>