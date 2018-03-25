<?php
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Levi Pole
		Hackathon 2018

    you can run this using the URL: http://nrs-projects.humboldt.edu/~arl505/hack/title_page.php
-->

<head>
    <title> Planet Rocket </title>
    <meta charset="utf-8" />   
	<meta name="viewport" content="initial-scale=1.0">
	
	<link href="http://nrs-projects.humboldt.edu/~lwp41/planetrocket/format.css"
          type="text/css" rel="stylesheet" />
	<link href="card.css" type="text/css" rel="stylesheet" />
	
	<style>
	table, tr, td, th
	{
		border: thin solid black;
		border-collapse: collapse; 
	}
	</style>
			
	<?php
		header('X-Frame-Options: GOFORIT'); 
		require_once("hsu_conn.php");
	?>
	
</head>

<body>
	<?php
	if(! array_key_exists('next-state', $_SESSION))
	{
		?>
		To view this page, you must have access to the main database. Enter your Oracle credentials.
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
		$_SESSION['next-state'] = '1goto';
	}
			
	elseif ($_SESSION['next-state'] == '1goto' )
	{
		if(array_key_exists('oracle_username', $_POST) and array_key_exists('oracle_password', $_POST))
		{
			$db_conn_str = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))';
			$oracle_username = $_POST['oracle_username'];
			$oracle_password = $_POST['oracle_password'];
			$_SESSION['oracle_username'] = $oracle_username;
			$_SESSION['oracle_password'] = $oracle_password;
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
				
			?>
	<h1> Planet Rocket </h1>
	
	<div class="dropdown-events">
		<button class="events"> <a href="#event-section"> Events </a> </button>
		<div class="dropdown-events-content">
			<a href="#schedule-section"> Schedule </a>
			<a href="#calendar-section"> Calendar </a> 
			<a href="#map-section"> Map </a> 
		</div>
	</div>
    <button type="button" class="nav"> <a href="#org-section"> Organization </a> </button>
    <button type="button" class="nav"> <a href="#login-section"> Login </a> </button>
	
    <h2> Important Events </h2>
    <?php	
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
						//$curr_time = oci_result($get_events_stmt, 'EVENT_TIME');
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
									<!--<p class="info"><?= $curr_date  ?>, <?= $curr_time ?></p>
									--><p class="info"><?= $curr_loc?></p>
								</div>
							</div> 
							<?php 
					}
					$count_to_four = $count_to_four + 1;
				}
				?>
				</div>
	
	<div class="holder" id="schedule-section"> <h1> schedule section </h1> 
		<div id="list"> 
		
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
			if(array_key_exists('oracle_username', $_SESSION) and array_key_exists('oracle_password', $_SESSION))
			{
				?>
				<?php
				$username = $_SESSION['oracle_username'];
				$password = $_SESSION['oracle_password'];
		
				$conn = hsu_conn($username, $password);  
				if($conn)
				{			
					$tracker = 0;				
				
					$count_query = 'select count(event_id)
									from event';
					$count_parse = oci_parse($conn, $count_query);
					oci_execute($count_parse, OCI_DEFAULT);
					if(oci_fetch($count_parse)){
						$count = oci_result($count_parse, "COUNT(EVENT_ID)");
					}
					?>
					<ul>
					<?php
					
					$query = 'select event_name, event_description, event_date, event_address
							  from event';
					$query_parse = oci_parse($conn, $query);
					oci_execute($query_parse, OCI_DEFAULT);
					
					?> <!--
						<table>
						<caption> Event Information </a>
							<tr> <th scope="col"> Name</th>
								 <th scope="cols"> Description</th>
								 <th scope="cols"> Date </th>
								 <th scope="cols"> Address </th>
							</tr> -->
						<?php 
					while ($tracker < $count)
					{
						if(oci_fetch($query_parse))
						{
							$curr_event_name = oci_result($query_parse, "EVENT_NAME");
							$curr_event_description = oci_result($query_parse, "EVENT_DESCRIPTION");
							$curr_event_date = oci_result($query_parse, "EVENT_DATE");
							$curr_event_address = oci_result($query_parse, "EVENT_ADDRESS");	
							?>
								<li> 
									<div class="values">
										<p> <?= $curr_event_name ?> </p>
										<p> <?=$curr_event_description ?> </p>
										<p> <?= $curr_event_date ?> </p>
										<p> <?= $curr_event_address ?> </p>
									</div>
								</li> <!--
									<tr><td><?= $curr_event_name ?> </td>
										<td><?= $curr_event_description ?> </td>
										<td><?= $curr_event_date ?> </td>
										<td><?= $curr_event_address ?> </td> </tr>  -->
							<?php
						}
						else
						{
						?>
							NO QUERY RESULTS!
						<?php
						}
						$tracker =  $tracker + 1;
					}
					?>
					</ul>
					<?php
				}
				session_destroy();
	
			}
		
		else
		{
			?>
			SHOULDN'T HAVE BEEN ABLE TO MAKE IT HERE! <br >
			<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
			<?php
			session_destroy();
			exit;
		}
		?>
	
		</div>
	</div>
	
	<div class="holder" id="calendar-section"> <h1> calendar section </h1> 	
		<iframe src="https://calendar.google.com/calendar/b/1/embed?height=600&amp;wkst=1
			&amp;bgcolor=%23FFFFFF&amp;src=mockupplanetrocket%40gmail.com&amp;color=%
			231B887A&amp;ctz=America%2FLos_Angeles" 
			style="border-width:0" width="800" height="600" 
			frameborder="0" >
		</iframe>
    </div>
	
	<div class="holder" id="map-section">
	<h1> Map section </h1>
		<a href="http://nrs-projects.humboldt.edu/~lwp41/planetrocket/map.html" class="map-link"> to map </a>
	</div>
			
	<?php
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
