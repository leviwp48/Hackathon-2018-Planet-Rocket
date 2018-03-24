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
    by: Alec Levin
    last modified: 23 March 2018

    you can run this using the URL:
		http://nrs-projects.humboldt.edu/~arl505/hack/mk-event.php
-->

<head>
    <title>mk-event.php</title>
    <meta charset="utf-8" />

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>
	<?php
	if(! array_key_exists('next-state', $_SESSION))
	{
		?>
		To add an event, you must login to the main database. Enter your Oracle credentials.
		<fieldset> <legend> Database Login </legend>
			<form action = "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
			  method = "post" /> 
				<label> Oracle Username: <br />
					<input type="text" name="oracle_username" required="required"/>
				</label> <br />
				<label> Oracle Password: <br />
					<input type="password" name="oracle_password" required="required" />
				</label> <br />
				<input type="submit" value="Submit" />
			</form>
		</fieldset>
		<?php
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
				
				Valid Oracle credentials, successful logon. Now please enter your individual 
				organization account logon information.
				<fieldset> <legend>Add Event Form</legend>
					<form action = "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
			 			 method = "post" /> 
			 			 <label> Organization Username: <br />
			 			 	<input type="text" name="org_username" required="required" />
			 			 </label> <br />
			 			 <label> Organization Password: <br />
			 			 	<input type="password" name="org_password" required="required" />
			 			 </label> <br />
			 			 <input type="submit" value="Submit" />
			 		</form>
			 	</fieldset>
				
				<?php
			
				$_SESSION['oracle_usr'] = $oracle_usr;
				$_SESSION['oracle_pwd'] = $oracle_pwd;
				$_SESSION['next-state'] = '3checkcreds';
			}
		}
		
		else
		{
			?>
			You shouldn't be here! <br />
			<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
			<?php
			session_destroy();
			exit;
		}
	}
	
	elseif($_SESSION['next-state'] == '3checkcreds')
	{
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
				?>
				Invalid Oracle Credentials <br />
				<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
				<?php
				session_destroy();
				exit;
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
					
					<fieldset> <legend> New Event Form </legend>
						<form action = "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
			 				method = "post" />
			 					<label> Event Name: <br />
			 						<input type="text" name="event_name" maxlength="500" required="required" />
			 					</label> <br />
			 					<label> Event Description: <br />
			 						<input type="text" name="event_description" maxlength="140" required="required" />
			 					</label> <br /> <br />
			 					Event Start Time: <br />
			 					<label> Day: 
			 						<select name="event_day">
			 							<option value="01">01</option>
			 							<option value="02">02</option>
			 							<option value="03">03</option>
			 							<option value="04">04</option>
			 							<option value="05">05</option>
			 							<option value="06">06</option>
			 							<option value="07">07</option>
			 							<option value="08">08</option>
			 							<option value="09">09</option>
			 							<option value="10">10</option>
			 							<option value="11">11</option>
			 							<option value="12">12</option>
			 							<option value="13">13</option>
			 							<option value="14">14</option>
			 							<option value="15">15</option>
			 							<option value="16">16</option>
			 							<option value="17">17</option>
			 							<option value="18">18</option>
			 							<option value="19">19</option>
			 							<option value="20">20</option>
			 							<option value="21">21</option>
			 							<option value="22">22</option>
			 							<option value="23">23</option>
			 							<option value="24">24</option>
			 							<option value="25">25</option>
			 							<option value="26">26</option>
			 							<option value="27">27</option>
			 							<option value="28">28</option>
			 							<option value="29">29</option>
			 							<option value="30">30</option>
			 							<option value="31">31</option>
			 						</select>
			 					</label> <br /> 
			 					<label> Month:
			 						<select name="event_month">
			 							<option value="JAN">01</option>
			 							<option value="FEB">02</option>
			 							<option value="MAR">03</option>
			 							<option value="APR">04</option>
			 							<option value="MAY">05</option>
			 							<option value="JUN">06</option>
			 							<option value="JUL">07</option>
			 							<option value="AUG">08</option>
			 							<option value="SEP">09</option>
			 							<option value="OCT">10</option>
			 							<option value="NOV">11</option>
			 							<option value="DEC">12</option>
			 						</select>
			 					</label> <br />
			 					
			 					<label> Year: 
			 						<input type="number" name="event_year" min="2018" max="2150" />
			 					</label> <br />
			 					<br />
			 					<label> Start time: <br />
			 						<input type="number" name="event_start_hour" min="01" max="12" /> : <input type="number" name="event_start_minute" min="01" max="12" />
			 					</label>
			 					<label> Event Address: <br />
			 						<input type="text" name="event_address" required="required" maxlength="75" />
			 					</label> <br />
			 					</label>
			 					<label> Event City: <br />
			 						<input type="text" name="event_city" required="required" maxlength="50" />
			 					</label> <br />
			 					</label> 
			 					<label> Event State: <br />
			 						<input type="text" name="event_state" required="required" maxlength="50" />
			 					</label> <br />
			 					</label> 	
			 					<label> Event Zip Code: <br />
			 						<input type="number" name="event_zip" required="required" maxlength="50" />
			 					</label> <br />
			 					<input type="submit" value="Submit" />
						</form>
					</fieldset>
					<?php
					$_SESSION['next-state'] = '4formresponse';
				}
				else
				{
					?>
					Invalid Organization Credentials
					<?php
				}
			}
		}
		
		else
		{
			?>
			You shouldn't be here! <br />
			<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
			<?php
			session_destroy();
			exit;
		}
	}
	
	elseif($_SESSION['next-state'] == '4formresponse')
	{
		$db_conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
		$oracle_usr = $_SESSION['oracle_usr'];
		$oracle_pwd = $_SESSION['oracle_pwd'];
		$conn = oci_connect($oracle_usr, $oracle_pwd, $db_conn_str);
		if(array_key_exists('event_address', $_POST) and array_key_exists('event_start_time', $_POST) and array_key_exists('event_name', $_POST) and array_key_exists('event_description', $_POST)   and array_key_exists('event_city', $_POST)  and array_key_exists('event_state', $_POST)  and array_key_exists('event_zip', $_POST) and array_key_exists('event_day', $_POST) and array_key_exists('event_month', $_POST) and array_key_exists('event_year', $_POST))
		{
			$event_start_time = $_POST['event_start_time'];
			$event_address = $_POST['event_address'];
			$event_name = $_POST['event_name'];
			$event_description = $_POST['event_description'];
			$event_city = $_POST['event_city'];
			$event_state = $_POST['event_state'];
			$event_zip = $_POST['event_zip'];
			//$event_day = 
			
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
				$new_row_str = "insert into event (event_id, event_date, event_time, event_name, event_description, event_address, event_city, event_state, event_zip)
								values
								(new_event_id.nextval, '".$event_date."', '".$event_start_time."', '".$event_name."', '".$event_description."', '".$event_address."', '".$event_city."', '".$event_state."', '".$event_zip."')";
				$new_row_stmt = oci_parse($conn, $new_row_str);
				$num_rows = oci_execute($new_row_stmt, OCI_DEFAULT);
				?>
				<?= $num_rows?> event has been added.
				<?php
				oci_commit($conn);
				oci_free_statement($new_row_stmt);
			}
			session_destroy();
		}
		else
		{
			?>
			You shouldn't be here! <br />
			<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
			<?php
			session_destroy();
			exit;
		}
		
	}
	
	else
	{
		?>
		You shouldn't be here! <br />
		<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
		<?php
		session_destroy();
		exit;
	}
	?>
	
</body>
</html>

