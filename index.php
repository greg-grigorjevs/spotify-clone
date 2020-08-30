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

        <div id="mainContainer">

            <div id="topContainer">                    
                <?php include("includes/navBarContainer.php"); ?>
            </div>

            <div id="mainViewContainer">
              <div id="mainContent"></div>
            </div>

            <?php include("includes/nowPlayingBarContainer.php") ?>

        </div>

    </body>
</html>
