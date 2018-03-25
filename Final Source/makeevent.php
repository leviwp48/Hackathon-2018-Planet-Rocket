<!--
		THIS PHP DOCUMENT MAKES USE OF A SEQUENCE WITHIN THE ORACLE DATABASE.
		THIS SEQUENCE MUST BE BUILT IN THE DB PRIOR TO USING THIS APP AND SHOULD ONLY
		BE DONE ONCE. YOU CAN BUILD THE SEQUENCE WITH BY ENTERING THE FOLLOWING COMMAND
		INTO SQL*PLUS:
		create sequence new_event_id
		start with 3000
		increment by 1;
-->

<?php
	session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alec Levin, css by Ben
    last modified: 23 March 2018
    you can run this using the URL:
		http://nrs-projects.humboldt.edu/~bam22/Lumberhacks2018/makeevent.php 
-->

<head>
    <title>mk-event.php</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="styles/layout.css">
    <link rel="stylesheet" type="text/css" href="styles/format.css">
    <?php
        require_once("form_injections.php");
    ?>
</head>

<body>
	<img class="landing-image" src="images/planet-rocket.png">
    <a href="logout.php"><button class="back">Logout</button></a>
    <h1>Make a New Event!</h1>
    <h2><?= $_SESSION['next-state'] ?></h2>
	<?php
	if(! array_key_exists('next-state', $_SESSION))
	{
		/*REPLACE THIS WITH AUTO LOGIN SHIT IN THE FUTUE*/
		?>
		
		<p>Login to Oracle, to be replaced by auto account</p>

		<?php
		oraclelogin();
		$_SESSION['next-state'] = '2checklogin';
	}
	elseif($_SESSION['next-state'] == '2checklogin')
	{
		
			if(array_key_exists('oracle_username', $_POST) and array_key_exists('oracle_password', $_POST))
			{
				$oracle_usr = $_POST['oracle_username'];
				$oracle_pwd = $_POST['oracle_password'];
				
				$db_conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
				$conn = oci_connect($oracle_usr, $oracle_pwd, $db_conn_str);
				if(!$conn)
				{
					failure();
				}
				else
				{
					if(!array_key_exists('uin', $_SESSION) and !array_key_exists('pin', $_SESSION)){
						?>
						<p>Valid Oracle credentials, successful logon. Now please enter your individual organization account logon information.</p>
						<h2><?= $_SESSION['next-state'] ?></h2>
						<?php
						addeventLog();	
						$_SESSION['oracle_usr'] = $oracle_usr;
						$_SESSION['oracle_pwd'] = $oracle_pwd;
						$_SESSION['next-state'] = '3checkcreds';
						}	
					else{
						
						$_SESSION['oracle_usr'] = $oracle_usr;
						$_SESSION['oracle_pwd'] = $oracle_pwd;
						$_SESSION['next-state'] = '3checkcreds';
						?>
						<script type="text/javascript">
							location.reload();
						</script>
						<?php
					}
				}
			}
			else
			{
				failure();
			}
		
		
		
	}
	
	elseif($_SESSION['next-state'] == '3checkcreds')
	{
		$_POST['org_username'] = $_SESSION['uin'];
		$_POST['org_password'] = $_SESSION['pin'];

		if(array_key_exists('org_username', $_POST) and array_key_exists('org_password', $_POST))
		{
			$org_username = $_POST['org_username'];
			$org_password = $_POST['org_password'];
			$oracle_usr = $_SESSION['oracle_usr'];
			$oracle_pwd = $_SESSION['oracle_pwd'];
			$db_conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
			$conn = oci_connect($oracle_usr, $oracle_pwd, $db_conn_str);
			if(!$conn)
			{
				failure();
			}
		
			else
			{
				$logon_ck_str = "select * 
								 from org_account
								 where org_username = '".$org_username."' and 
								 org_password = '".$org_password."'"; 
				$logon_ck_stmt = oci_parse($conn, $logon_ck_str);
				oci_execute($logon_ck_stmt, OCI_DEFAULT);
				
				if(oci_fetch($logon_ck_stmt))
				{
					$_SESSION['org_username'] = $org_username;
					$_SESSION['org_password'] = $org_password;
					?>
					
					<?php
					addevent();
					$_SESSION['next-state'] = '4formresponse';
				}
				else
				{
					?>
					<p>Invalid Organization Credentials<
					<?php
				}
			}
		}
		
		else
		{
			failure();
		}
	}
	
	elseif($_SESSION['next-state'] == '4formresponse')
	{
		$db_conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
		$oracle_usr = $_SESSION['oracle_usr'];
		$oracle_pwd = $_SESSION['oracle_pwd'];
		$conn = oci_connect($oracle_usr, $oracle_pwd, $db_conn_str);
		if(array_key_exists('event_address', $_POST) and array_key_exists('event_name', $_POST) and array_key_exists('event_description', $_POST)   and array_key_exists('event_city', $_POST)  and array_key_exists('event_state', $_POST)  and array_key_exists('event_zip', $_POST) and array_key_exists('event_day', $_POST) and array_key_exists('event_month', $_POST) and array_key_exists('event_year', $_POST) and array_key_exists('event_start_hour', $_POST) and array_key_exists('event_start_minute', $_POST))
		{
			$event_address = $_POST['event_address'];
			$event_name = $_POST['event_name'];
			$event_description = $_POST['event_description'];
			$event_city = $_POST['event_city'];
			$event_state = $_POST['event_state'];
			$event_zip = $_POST['event_zip'];
			$event_day = $_POST['event_day'];
			$event_month = $_POST['event_month'];
			$event_year = $_POST['event_year'];
			$event_start_hour = $_POST['event_start_hour'];
			$event_start_minute = $_POST['event_start_minute'];
			$event_aorp = $_POST['event_aorp'];
			$date_str = $event_day."-".$event_month."-".$event_year." ".$event_start_hour.":".$event_start_minute." ".$event_aorp;
			
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
				$new_row_str = "insert into event (event_id, event_date, event_name, event_description, event_address, event_city, event_state, event_zip)
								values
								(new_event_id.nextval, to_date('".$date_str."','DD-MON-YY HH:MI PM'), '".$event_name."', '".$event_description."', '".$event_address."', '".$event_city."', '".$event_state."', '".$event_zip."')";
				$new_row_stmt = oci_parse($conn, $new_row_str);
				$change_format_str = "alter session set NLS_DATE_FORMAT = 'dd-MON-yyyy HH24:mi'";
				$change_format_stmt = oci_parse($conn, $change_format_str);
				oci_execute($change_format_stmt, OCI_DEFAULT);
				$num_rows = oci_execute($new_row_stmt, OCI_DEFAULT);
				
				$get_eid_str = "select event_id
								   from event
								   where event_name = '".$event_name."'
										and event_description = '".$event_description."'";
				$get_eid_stmt = oci_parse($conn, $get_eid_str);
				oci_execute($get_eid_stmt, OCI_DEFAULT);
				if(oci_fetch($get_eid_stmt))
				{
					$event_id = oci_result($get_eid_stmt, 'EVENT_ID');
				}
				
				$org_username = $_SESSION['org_username'];
				$org_password = $_SESSION['org_password'];
				$get_oid_str = "select org_id
								   from org_account
								   where org_username = '".$org_username."'
										and org_password = '".$org_password."'";
				$get_oid_stmt = oci_parse($conn, $get_oid_str);
				oci_execute($get_oid_stmt, OCI_DEFAULT);
				if(oci_fetch($get_oid_stmt))
				{
					$org_id = oci_result($get_oid_stmt, 'ORG_ID');
				}
				
				if(($org_id) and ($event_id))
				{
					$insert_new_str = "insert into org_has_event 
									   values
									   (".$org_id.", ".$event_id.")";
					$insert_new_stmt = oci_parse($conn, $insert_new_str);
					oci_execute($insert_new_stmt, OCI_DEFAULT);
					oci_commit($conn);
				}
				
				?>
				
				<?php
				oci_commit($conn);
				oci_free_statement($new_row_stmt);
				oci_free_statement($get_eid_stmt);
				oci_free_statement($insert_new_stmt);
				oci_free_statement($get_oid_stmt);
				oci_free_statement($change_format_stmt);
			}
			?>
			<div class="alignbtn">
				<p><?= $num_rows?> event has been added.</p>
				<a href="profile.php"><button>Back to Profile</button></a>
			</div>
			
			<?php
			unset($_SESSION['next-state']);
		}
		else
		{
			failure();
		}
		
	}
	
	else
	{
		failure();
	}
	?>
	
</body>
</html>