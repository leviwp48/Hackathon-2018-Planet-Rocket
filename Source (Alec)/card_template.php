<?php
	session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Eric Mott and Alec Levin
    last modified: 03/24/18

    you can run this using the URL:
	http://nrs-projects.humboldt.edu/~arl505/hack/card_template.php
-->

<head>
    <title>Card Test</title>
    <meta charset="utf-8" />

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
    <link href="card.css" type="text/css" rel="stylesheet" />
    
</head>
<body>
	
	<?php
	if(! array_key_exists('next-state', $_SESSION))
	{
		?>
		To view events, you must login to the main database. Enter your Oracle credentials.
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
			$db_conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
			$oracle_username = $_POST['oracle_username'];
			$oracle_password = $_POST['oracle_password'];
			$conn = oci_connect($oracle_username, $oracle_password, $db_conn_str);
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
				$get_events_str = 'select *
								   from event
								   order by event_date';
				$get_events_stmt = oci_parse($conn, $get_events_str);
				oci_execute($get_events_stmt, OCI_DEFAULT);
				$count_to_four = 0;
				?>
				<div class="wrapper">
				<?php
				while($count_to_four < 4)
				{
					if(oci_fetch($get_events_stmt))
					{
						$curr_eid = oci_result($get_events_stmt, 'EVENT_ID');
						$curr_name = oci_result($get_events_stmt, 'EVENT_NAME');
						$curr_description = oci_result($get_events_stmt, 'EVENT_DESCRIPTION');
						$curr_date = oci_result($get_events_stmt, 'EVENT_DATE');
						$curr_time = oci_result($get_events_stmt, 'EVENT_TIME');
						$curr_street_address = oci_result($get_events_stmt, 'EVENT_ADDRESS');
						$curr_city = oci_result($get_events_stmt, 'EVENT_CITY');
						$curr_state = oci_result($get_events_stmt, 'EVENT_STATE');
						$curr_zip = oci_result($get_events_stmt, 'EVENT_ZIP');
						$curr_loc = $curr_street_address.", ".$curr_city.", ".$curr_state.", ".$curr_zip;
						
						$find_oid_str = 'select org_id
										 from org_has_event
										 where event_id = :event_id';
						$find_oid_stmt = oci_parse($conn, $find_oid_str);
						oci_bind_by_name($find_oid_stmt, ':event_id', $curr_eid);
						oci_execute($find_oid_stmt, OCI_DEFAULT);
						$event_owners = "";
						while(oci_fetch($find_oid_stmt))
						{
							$curr_oid = oci_result($find_oid_stmt, 'ORG_ID');
							$get_name_str = "select org_name
											 from org_account
											 where org_id = :org_id";
							$get_name_stmt = oci_parse($conn, $get_name_str);
							oci_bind_by_name($get_name_stmt, ':org_id', $curr_oid);
							oci_execute($get_name_stmt, OCI_DEFAULT);
							
							if(oci_fetch($get_name_stmt))
							{
								$curr_owner = oci_result($get_name_stmt, 'ORG_NAME');
							}
							
							else
							{
								$curr_owner = "";
							}
							
							if($event_owners == "")
							{
								$event_owners = $curr_owner;
							}
							else
							{
								$event_owners = $event_owners." and ".$curr_owner;
							}
						}
						
						?>
								<div class="card">
								<div class="org">
									<img src="black.jpeg" alt="Avatar" class="avatar">
									<h3 class="av_header"> <?= $event_owners ?></h3>
								</div>
								<img src="hsu_lib.jpg" style="width:100%">
								<div class="text">
									<h4 class="header"><?= $curr_name ?></h4>
									<p class="info"><?= $curr_description ?></p>
									<p class="info"><?= $curr_date  ?>, <?= $curr_time ?></p>
									<p class="info"><?= $curr_loc?></p>
								</div>
							</div>
							<?php
					}
					$count_to_four = $count_to_four + 1;
				}
				?>
				</div>
				<?php
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
	?>
	
</body>
</html>


