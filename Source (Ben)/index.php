
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
    <button class="back">Back</button>
    <a href="logout.php"><button>Logout/DestroySession</button></a>

    <div id="view1" class="visible">
        <h1> Welcome to Volunteering! </h1>
        <p> Are you are Volunteer or an Organization? </p>
        <div class="alignbtn">
            <button id="vol" name="volunteer">I am a Volunteer</button>
            <button id="org" name="organizer">I am an Organization</button>
        </div>
    </div>

    <div id="view2" class="hidden">
        <h2> Welcome to Planet Rocket! Do you have an Account?</h2>
        <div class="alignbtn">
            <a href="org_login.php" style="text-decoration: none;"><button id="org_login">Yes Login</button></a>
            <button id="org_reg">No, <span style="text-decoration: underline;">Register</span></button>
        </div>
    </div>

    <div id="register-form" class="hidden">
        <?php
        if(! array_key_exists("next-state", $_SESSION))
        {
            ?>
            <h1> Register your organization </h1>
            <?php
            org_register1();
            $_SESSION["next-state"] = "second";
        }
        
        elseif($_SESSION["next-state"] == "second")
        {
            if(array_key_exists('password', $_POST) and array_key_exists('password2', $_POST))
            {
                if($_POST['password'] != $_POST['password2'])
                {
                    ?>
                    <h1>The passwords did not match, please try again!</h1>
                    <?php
                    org_register1();
                    
                }
                else
                {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['password'] = $_POST['password'];
                    ?>
                    <h1>More Info</h1>
                    <?php
                    org_register2();
                    $_SESSION['next-state'] = 'third';
                }
            }
            
            else
            {
                failure();
            }
            
        }
        
            elseif($_SESSION['next-state'] == 'third')
            {
                if(array_key_exists('org_name', $_POST))
                {
                    $_SESSION['org_name'] = $_POST['org_name'];
                    
                    if(array_key_exists('mail_address', $_POST))
                    {
                        $_SESSION['mail_address'] = $_POST['mail_address'];
                    }
                    
                    if(array_key_exists('mail_address', $_POST))
                    {
                        $_SESSION['mail_address'] = $_POST['mail_address'];
                    }       
                    
                    if(array_key_exists('org_phone', $_POST))
                    {
                        $_SESSION['org_phone'] = $_POST['org_phone'];
                    }
                    
                    if(array_key_exists('org_url', $_POST))
                    {
                        $_SESSION['org_url'] = $_POST['org_url'];
                    }           
                    ?> 
                        <h1>Oracle Login to Add Org</h1>                       
                    <?php
                        oraclelogin();
                        $_SESSION['next-state'] = 'fourth';
                }
                else
                {
                    failure();
                }
                
            }
            
            elseif($_SESSION['next-state'] == 'fourth')
            {
                if(array_key_exists('oracle_username', $_POST) and array_key_exists('oracle_password', $_POST))
                {
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
                        exit;
                    }
                    
                    else
                    {
                        ?>
                            <div id="hideme" class="nextstate"></div>
                        <?php
                        $new_row_str = "insert into org_account (org_id, org_username, org_password, org_name)
                                        values
                                        (new_org_id.nextval, :org_username, :org_password, :org_name)";
                        $new_row_stmt = oci_parse($conn, $new_row_str);
                        oci_bind_by_name($new_row_stmt, ':org_username', $_SESSION['username']);
                        oci_bind_by_name($new_row_stmt, ':org_password', $_SESSION['password']);
                        oci_bind_by_name($new_row_stmt, ':org_name', $_SESSION['org_name']);
                        $numrows = oci_execute($new_row_stmt, OCI_DEFAULT);
                        oci_commit($conn);
                        
                        if(array_key_exists('mail_address', $_SESSION))
                        {
                            $update_mail_str = "update org_account
                                                set org_address = '".$_SESSION['mail_address']."' 
                                                where org_username = '".$_SESSION['username']."'";
                            $update_mail_stmt = oci_parse($conn, $update_mail_str);
                            oci_execute($update_mail_stmt, OCI_DEFAULT);
                            oci_commit($conn);
                        }
                        
                        if(array_key_exists('org_phone', $_SESSION))
                        {
                            $update_phone_str = "update org_account
                                                set org_phone_num = '".$_SESSION['org_phone']."' 
                                                where org_username = '".$_SESSION['username']."'";
                            $update_phone_stmt = oci_parse($conn, $update_phone_str);
                            oci_execute($update_phone_stmt, OCI_DEFAULT);
                            oci_commit($conn);
                        }
                        
                        if(array_key_exists('org_url', $_SESSION))
                        {
                            $update_url_str = "update org_account
                                                 set org_url = '".$_SESSION['org_url']."' 
                                                 where org_username = '".$_SESSION['username']."'";
                            $update_url_stmt = oci_parse($conn, $update_url_str);
                            oci_execute($update_url_stmt, OCI_DEFAULT);
                            oci_commit($conn);
                            oci_free_statement($update_url_stmt);
                            oci_free_statement($update_mail_stmt);
                            oci_free_statement($update_phone_stmt);
                            oci_free_statement($new_row_stmt);
                        }                                               
                        
                        ?>
                        <div class="alignbtn">
                            <p>You made <?= $numrows ?> new account.</p>
                            <button class="org_to_log"> Back to Front </button>
                        </div>
                        
                        <?php
                        session_destroy();
                    }
                }              
                else
                {
                    failure();
                }
            }
            ?>
    </div>

 
</body>
</html>