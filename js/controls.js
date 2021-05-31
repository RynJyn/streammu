var newsrc = 'images/pause.png'; 

function playOrPause() {
if (newsrc == 'images/pause.png')
{
document.images['pic'].src = 'images/pause.png';
document.getElementById('track').play(); 
newsrc = 'images/play.png';
}
else if (newsrc == 'images/play.png')
{
document.images['pic'].src = 'images/play.png';
document.getElementById('track').pause(); 
newsrc = 'images/pause.png';
}
}

function stop() {
document.getElementById('track').pause(); 
document.getElementById('track').currentTime=0;
document.images['pic'].src = 'images/play.png';
newsrc = 'images/pause.png';
}

function fastFwd(){
song.currentTime = song.currentTime + 10;
}

function rewind(){
song.currentTime = song.currentTime - 10;
}

function next(){
trackID = trackID + 1;
document.location = "track.php?trackid=" + trackID;
}

function prev(){
trackID = trackID - 1;
document.location = "track.php?trackid=" + trackID;
}

function playTrack()
{
song = document.getElementById('track');
var trackMins = Math.floor((song.currentTime) / 60);
var trackSecs = Math.floor((song.currentTime) - (trackMins*60)); 
//Gets the current track time in minutes and seconds
var durationMins = Math.floor((song.duration) / 60);
var durationSecs = Math.floor((song.duration) - (durationMins*60));
//Gets the overall track time in minutes and seconds
var progress = (song.currentTime/song.duration) * 100;
if (trackSecs < 10)
{
trackSecs = '0' + trackSecs; //If the seconds count is <10, add an extra 0 to prevent formatting such as 00:0;
}
if (durationSecs < 10)
{
durationSecs = '0' + durationSecs; //If the seconds count is <10, add an extra 0 to prevent formatting such as 00:0;
}
document.getElementById('tracktime').innerHTML = trackMins + ':' + trackSecs; //Sets the current track time to the format of 00:00;
document.getElementById('trackduration').innerHTML = durationMins + ':' + durationSecs; //Sets the overall track time to the format of 00:00;
document.getElementById('progressbar').style.width = progress + '%'; //As the song progresses, the progress bar's width is increased by a certain percentage, and is applied in the CSS.
if (song.currentTime == song.duration)
{
stop(); //Prevents the track from repeating
}
}
