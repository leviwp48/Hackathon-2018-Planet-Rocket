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
    by: Alec Levin	
    last modified: 23 March 2018

    you can run this using the URL:
	nrs-projects.humboldt.edu/~arl505/hack/org-signup.php		
-->

<head>
    <title>org-signup.php</title>
    <meta charset="utf-8" />

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>

	<?php
		if(! array_key_exists("next-state", $_SESSION))
		{
			?>
			Welcome! Use the following forms to create a new organization account.
			<fieldset> <legend> Create Account </legend>
			<form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
				  method="post"> 
				  <label> *Organization Username (15 character maximum): <br />	
				  		<input type="text" name="username" required="required" maxlength="15"/>
				  </label> <br />
			  
				  <label> *Organization Password (40 character maximum): <br />
				  		<input type="password" name="password" required="required" maxlength="40"/>
				  </label> <br />
			  
				  <label> *Confirm Organization Password: <br />
				  		<input type="password" name="password2" required="required" />
				  </label> <br />
				  * indicates a required field <br />
				  <input type="submit" value="Submit" />
			</form>
			</fieldset>
			<?php			
			$_SESSION["next-state"] = "second";
		}
		
		elseif($_SESSION["next-state"] == "second")
		{
			if(array_key_exists('password', $_POST) and array_key_exists('password2', $_POST))
			{
				if($_POST['password'] != $_POST['password2'])
				{
					?>
					The passwords you entered did not match, please try again. 
					<fieldset> <legend> Create Account </legend>
						<form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
							  method="post"> 
								  <label> *Organization Username (15 character maximum): <br />
				  					<input type="text" name="username" required="required" maxlength="15"/>
				  				  </label> <br />
			  
								  <label> *Organization Password (40 character maximum): <br />
				  					<input type="password" name="password" required="required" maxlength="40"/>
				  				  </label> <br />
			  
				 				  <label> *Confirm Organization Password: <br />
				  					<input type="password" name="password2" required="required" />
				  				  </label> <br />
				  				  * indicates a required field <br />
				 				 <input type="submit" value="Submit" />
						</form>
					</fieldset>
					<?php
				}
				else
				{
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['password'] = $_POST['password'];
					?>
   				  <fieldset> <legend> More Info </legend>
   				  	<form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
							  method="post"> 
					  	<label> *Organization Name: <br />
					  		<input type="text" name="org_name" maxlength="50" required="required" />
					  	</label> <br />
					  	<label> Organization Mailing Address: <br />
				  			<input type="text" name="mail_address" maxlength="50" />
				 	 	</label> <br />
					  	<label> Organization Telephone Number: <br />
					  		<input type="tel" name="org_phone" maxlength="10" />
					  	</label> <br />
					  	<label> Organization Website URL: <br />
					  		<input type="tel" name="org_url" maxlength="50" />
					  	</label> <br />  	
					  	* indicates a required field <br />
					  	<input type="submit" value="Submit" />
					  </form>
				  </fieldset>
				  <?php
				  $_SESSION['next-state'] = 'third';
				}
			}
			
			else
			{
				?>
				You shouldn't be here <br />
				<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
				<?php
				session_destroy();
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
						Now, enter your credentials to access the database and commit your new account.
						<fieldset> <legend> Oracle Login </legend>
							<form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
								  method="post">
								<label> Oracle Username: <br />
									<input type="text" name="oracle_username" required="required" />
								</label> <br />
								<label> Oracle Password: <br />
									<input type="password" name="oracle_password" required="required" />
								</label> <br />
								<input type="submit" value="Submit" />
							</form>
						</fieldset>
						
					<?php
					$_SESSION['next-state'] = 'fourth';
				}
				else
				{
					?>
					You shouldn't be here <br />
					<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
					<?php
					session_destroy();
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
						You made <?= $numrows ?> new account.
						<?php
						session_destroy();
					}
				}
				
				else
				{
					?>
					You shouldn't be here <br />
					<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
					<?php
					session_destroy();
				}
				
			}
			?>
</body>
</html>
