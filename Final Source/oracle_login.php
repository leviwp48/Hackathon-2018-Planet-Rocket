<?php
    session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--
    by: Benjamin Miller
    last modified: 25 March 2018
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
    <h1>Oracle Login</h1>
    <?php
        if(!array_key_exists('oracle_username', $_POST) and !array_key_exists('oracle_password', $_POST)){
            oraclelogin();
        }
        else{
            $usr = $_POST['oracle_username'];
            $pwd = $_POST['oracle_password'];
            
            $_SESSION['oracle_username'] = $usr;
            $_SESSION['oracle_password'] = $pwd;
            
            $conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
            $conn = oci_connect($usr, $pwd, $conn_str);
            if(!$conn)
                {
                    ?>
                    Invalid Oracle Credentials <br />
                    <a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
                    <?php
                    session_destroy();
                    ?>
                    <a href="oracle_login.php"><button>Retry?</button></a>
                    <?php
                }
            else{
                $_SESSION['conn'] = $conn;
                $_SESSION['next-state'] = 'place_2';
                header("Location:title_page.php");
            }
            
        }
    ?>

</body>
</html>