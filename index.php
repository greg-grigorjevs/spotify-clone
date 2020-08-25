<?php
include("includes/config.php");

if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
} else {
    header("Location: register.php");
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
    <body>

        <div id="nowPlayingBarContainer">

            <div id="nowPlayingBar">
                <div id="nowPlayingLeft">
                </div> 
                <div id="nowPlayingCenter">
                    <div class="content playerControls">
                        <div class="buttons">
                            <button class="controlButton" title="Shuffle button">
                                <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                            </button>

                            <button class="controlButton" title="Previous button">
                                <img src="assets/images/icons/previous.png" alt="Previous">
                            </button>

                            <button class="controlButton" title="Play button">
                                <img src="assets/images/icons/play.png" alt="Play">
                            </button>

                            <button class="controlButton" title="Pause button">
                                <img src="assets/images/icons/pause.png" alt="Pause" style="display: none">
                            </button>

                            <button class="controlButton" title="Next button">
                                <img src="assets/images/icons/next.png" alt="Next">
                            </button>

                            <button class="controlButton" title="Repeat button">
                                <img src="assets/images/icons/repeat.png" alt="Repeat">
                            </button>

                        </div>
                    </div>
                </div> 
                <div id="nowPlayingRigth">
                </div> 
            </div>
            
        </div>

    </body>
</html>
