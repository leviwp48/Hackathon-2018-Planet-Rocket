
<!--
        THIS PHP DOCUMENT MAKES USE OF A SEQUENCE WITHIN THE ORACLE DATABASE.
        THIS SEQUENCE MUST BE BUILT IN THE DB PRIOR TO USING THIS APP AND SHOULD ONLY
        BE DONE ONCE. YOU CAN BUILD THE SEQUENCE WITH BY ENTERING THE FOLLOWING COMMAND
        INTO SQL*PLUS:
        create sequence new_org_id
        start with 7000
        increment by 1;
-->

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
        <a href="logout.php"><button class="back">Back</button></a>
    </body>

        <div id="login-form" class="visible">
        <h1>Organization Login</h1>
        <?php
            if(!array_key_exists('org-user-in', $_POST)){
                ?>
                <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>" method="post">
                    <fieldset>
                        <label for="user-in">UserName: </label>
                        <input type="text" name="org-user-in" Value="Username" required>
                        <label for="pass-in">Password: </label>
                        <input type="password" name="org-pass-in" required>
                        <input type="submit" name="login" value="Login">
                    </fieldset>
                </form>
                <?php
            }
            else{
                unset($_SESSION['next-state']);
                $orguin = $_POST['org-user-in'];
                $orgpin = $_POST['org-pass-in'];

                $_SESSION['uin'] = $orguin;
                $_SESSION['pin'] = $orgpin;

                $conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';

                $conn = oci_connect('bam22', 'Luna68196', $conn_str);
                if(!$conn)
                {
                    ?>
                    Invalid Oracle Credentials <br />
                    <a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
                    <?php
                    session_destroy();
                    exit;
                }
                else{
                    ?>
                    
                    <?php
                    /*$update_mail_str = "update org_account
                                                set org_address = '".$_SESSION['mail_address']."' 
                                                where org_username = '".$_SESSION['username']."'";
                            $update_mail_stmt = oci_parse($conn, $update_mail_str);
                            oci_execute($update_mail_stmt, OCI_DEFAULT);
                            oci_commit($conn);*/

                    $check_login = "SELECT count(*)
                                    FROM org_account
                                    WHERE org_username = :UserName
                                    AND org_password = :UserPassword";

                    $check_login_parse = ociparse($conn, $check_login);

                    oci_bind_by_name($check_login_parse, ":UserName", $_POST['org-user-in']);
                    oci_bind_by_name($check_login_parse, ":UserPassword", $_POST['org-pass-in']);

                    oci_execute($check_login_parse);

                    ocifetch($check_login_parse);

                    $num_users = oci_result($check_login_parse, "COUNT(*)");

                    if($num_users == 1){

                        $get_info = "SELECT org_name, org_address, org_phone_num, org_url
                                    FROM org_account
                                    WHERE org_username = :UserName
                                    AND org_password = :UserPassword";

                        $get_info_parse = ociparse($conn, $get_info);

                        oci_bind_by_name($get_info_parse, ":UserName", $_POST['org-user-in']);
                        oci_bind_by_name($get_info_parse, ":UserPassword", $_POST['org-pass-in']);
                        oci_execute($get_info_parse);
                        if( oci_fetch($get_info_parse) ){
                            $_SESSION["org_name"] = oci_result($get_info_parse, "ORG_NAME");
                            $_SESSION["org_phone"] = oci_result($get_info_parse, "ORG_PHONE_NUM");
                            $_SESSION["org_address"] = oci_result($get_info_parse, "ORG_ADDRESS");
                            $_SESSION["org_url"] = oci_result($get_info_parse, "ORG_URL");
                        }

                        ocifreestatement($check_login_parse);
                        oci_close($conn);
                        header("Location:profile.php");
                    }
                    else{
                        ?>
                        <h2>You have entered the wrong username or password, please try again</h2>
                        <?php
                    }
                }
            }
        ?>
    </div>
</html>