<?php
    session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--
    by: Alec Levin, Benjamin Miller
    last modified: 24 March 2018
    you can run this using the URL:
    nrs-projects.humboldt.edu/~bam22/Lumberhacks2018/index.php       
-->
<head>
    <title> Planet Rocket </title>
    <meta charset="utf-8" />

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="styles/layout.css">
    <link rel="stylesheet" type="text/css" href="styles/format.css">
    <script src="scripts/buttons.js"></script>
    <?php
        require_once("form_injections.php");
    ?>
     
</head>
<body>
    <img class="landing-image" src="images/planet-rocket.png">
    <a href="logout.php"><button class="back">Logout</button></a>
    <h1>Org Profile</h1>
    <?php 
        if(!array_key_exists("uin", $_SESSION)){
            ?>
            <h1> Please <a href="org_login.php">Login</a></h1>
            <?php
        }
        else{
            ?>
            <main>
                <h2>Welcome <?= $_SESSION["org_name"]?></h2>
                <p>Phone: <?= $_SESSION["org_phone"]?></p>
                <p>Address: <?= $_SESSION["org_address"]?></p>
                <p>Url: <?= $_SESSION["org_url"]?></p>
            </main>
            <a href="makeevent.php"><button class="event-btn org-nav">Create Event</button></a>
            <a><button class="org-nav">Placeholder</button></a>
            <a><button class="org-nav">Placeholder</button></a>
            <a><button class="org-nav">Placeholder</button></a>
            <a><button class="org-nav">Placeholder</button></a>
            <a><button class="org-nav">Placeholder</button></a>
            <div class="profile-image-cont"><img src="images/planet-rocket.png" class="profile-img"></div>
            <?php
        }
    ?>
    
</body>
</html>