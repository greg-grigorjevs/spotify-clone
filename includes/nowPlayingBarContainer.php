<?php

$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);

?>

<script charset="utf-8">

$(document).ready(function() {
    var newPlaylist = <?php echo $jsonArray; ?>;
    //create our audio object
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown mousemove touchstart touchmove", e => {
        e.preventDefault();
    })

    $(".playbackBar .progressBar").mousedown(function() {
        mousedown = true;
    })

    $(".playbackBar .progressBar").mousemove((e) => {
        // set time of the song depending on mouse position
        if (mousedown) {
            // for some reason $(this) this does not work 
            var progressBar = $(".playbackBar .progressBar");
            timeFromOffset(e, progressBar); 
        }
    })

    $(".playbackBar .progressBar").mouseup((e) => {
        var progressBar = $(".playbackBar .progressBar");
       timeFromOffset(e, progressBar); 
    })

    $(".volumeBar .progressBar").mousedown(function() {
        mousedown = true;
    })

    $(".volumeBar .progressBar").mousemove(function(e) {
        // set volume depending on mouse position
        if (mousedown) {
            const percentage = e.offsetX / $(this).width();
            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        }
    })

    $(".volumeBar > .progressBar").mouseup((e) => {
        // if I am using arrow function $(this) would not work
        // so I have to use e.currentTarget
        if (mousedown) {
            const percentage = e.offsetX / $(e.currentTarget).width();
            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        }
    })

    $(document).mouseup(() => {
       mousedown = false; 
    })

})

function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
}

function prevSong() {
    if (audioElement.audio.currentTime <= 3 || currentIndex == 0) {
        audioElement.setTime(0);
    } else {
        currentIndex--;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
}

function nextSong() {
    if (repeat) {
        audioElement.setTime(0);
        playSong();
        return;
    }
    if (currentIndex == currentPlaylist.length - 1) {
        currentIndex = 0;
    } else {
        currentIndex++;
    }

    const trackToPlay = shuffle ? shuffledPlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
    repeat = !repeat;
    const imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    const imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setShuffle() {
    shuffle = !shuffle;
    const imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

    if (shuffle) {
        //randomize the playlist
        //shuffledPlaylist = shufflePlaylist(currentPlaylist);
        currentIndex = shuffledPlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
        //go back to regular playlist
        currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
}

function shufflePlaylist(playlist) {
    var shuffledArr = playlist.slice();
    var currentIndex = shuffledArr.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = shuffledArr[currentIndex];
    shuffledArr[currentIndex] = shuffledArr[randomIndex];
    shuffledArr[randomIndex] = temporaryValue;
    }

    return shuffledArr;
}

function setTrack(trackId, newPlaylist, play) {
    if (newPlaylist != currentPlaylist) {
        currentPlaylist = newPlaylist;
        shuffledPlaylist = shufflePlaylist(currentPlaylist);
    }

    if (shuffle) {
        currentIndex = shuffledPlaylist.indexOf(trackId);

    } else {
        currentIndex = currentPlaylist.indexOf(trackId);

    }
    
    $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {
        const track = JSON.parse(data);
        $(".trackName span").text(track.title);

        // get Artist name
        $.post("includes/handlers/ajax/getSongArtist.php", {artistId: track.artist}, function(data) {
            const artist = JSON.parse(data);
            $(".artistName span").text(artist.name);
        })

        // get Album's cover
        $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
           const album = JSON.parse(data);
           $(".albumLink img").attr("src", album.artworkPath);
        })
        audioElement.setTrack(track);
        if(play) {
            playSong();
            audioElement.play();
            
        }

    })
    
}

function playSong() {
    if (audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentlyPlaying.id});
    }
    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play()
}

function pauseSong() {
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();
    audioElement.pause();
}

</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="" class="albumArtwork">
                </span>

                <div class="trackInfo">

                    <span class="trackName">
                        <span></span>
                    </span>

                    <span class="artistName">
                        <span></span>
                    </span>

                </div>
            </div>
        </div> 
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous button" onclick="prevSong()">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play button" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause button" style="display: none" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="Pause" >
                    </button>

                        <button class="controlButton next" title="Next button" onclick="nextSong()">
                            <img src="assets/images/icons/next.png" alt="Next">
                        </button>

                        <button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
                            <img src="assets/images/icons/repeat.png" alt="Repeat">
                        </button>



                </div>
                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>

                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>

                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div> 
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>

            </div>
        </div> 
    </div>

</div>
