
<?php
	function org_register1(){
		?>
            <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
                  method="post">
                <fieldset>
	                <label for="username"> *Organization Username (15 character maximum): </label>
	                    <input type="text" name="username" maxlength="15" required/>
	                
	              
	                <label for="password"> *Organization Password (40 character maximum): </label>
	                    <input type="password" name="password" maxlength="40" required/>
	                
	                <label for="password2"> *Confirm Organization Password: </label>
	                    <input type="password" name="password2" required/>
	                <input type="submit" value="Submit" />
                </fieldset>
            </form>
           	
            <?php
	}

	function org_register2(){
		?>
            <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
                      method="post"> 
                <fieldset>
                <label for="org_name"> *Organization Name: </label>
                    <input type="text" name="org_name" maxlength="50" required/>
                
                <label for="mail_address"> Organization Mailing Address: </label>
                    <input type="text" name="mail_address" maxlength="50" />

                <label for="org_phone"> Organization Telephone Number: </label>
                    <input type="tel" name="org_phone" maxlength="10" />

                <label for="org_url"> Organization Website URL: </label>
                    <input type="url" name="org_url" maxlength="50" />   
                <input type="submit" value="Submit" />
                </fieldset>
            </form>
            <div id="hideme" class="nextstate"></div>
		<?php
	}

	function failure(){
		?>
		<div id="hideme" class="nextstate"></div>
		<div class="alignbtn">
            You shouldn't be here <br />
            <a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">Return</a>
        </div>
        <?php
        session_destroy();
	}

	function oraclelogin(){
		?>
            <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
                  method="post">
                <fieldset> 
	                <label for="oracle_username"> Oracle Username: </label>
	                    <input type="text" name="oracle_username" required="required" />
	                
	                <label for="oracle_password"> Oracle Password: </label>
	                    <input type="password" name="oracle_password" required="required" />
	                <input type="submit" value="Submit" />
            	</fieldset>
            </form>
            <div id="hideme" class="nextstate"></div>
        <?php
	}
?>