
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
        exit;
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

    function addeventLog(){
        ?>
        <h2>Add Event Form</h2>
            <form action = "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
                 method = "post"/>
                <fieldset> 
                    <label for="org_username"> Organization Username: </label>
                        <input type="text" name="org_username" required="required" />
                    <label for="org_password"> Organization Password: </label> 
                        <input type="password" name="org_password" required="required" />
                    <input type="submit" value="Submit" />
                </fieldset>
            </form>
        <?php
    }

    function addevent(){
        ?>
        <h2> New Event Form </h2>
            <form action = "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
                method = "post" />
                <fieldset> 
                    <label for="event_name"> Event Name: </label>
                        <input type="text" name="event_name" maxlength="500" required="required" />
                    <label for="event_description"> Event Description: </label>
                        <input type="text" name="event_description" maxlength="140" required="required" />

                    <h3> Event Date: </h3> 
                    <label for="event_day"> Day: </label>
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
                    <label for="event_month"> Month: </label>
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
                    
                    <label for="event_year"> Year: </label>
                        <input type="number" name="event_year" min="2018" max="2150" />

                    <label for="event_start_hour"> Start time: </label>
                        <input type="number" name="event_start_hour" min="01" max="12" required="required"  /> <p>:</p> <input required="required" type="number" name="event_start_minute" min="00" max="59" />
                        <select name="event_aorp"/>
                            <option value="AM"/>AM</option>
                            <option value="PM"/>PM</option>
                        </select>

                    <label for="event_address"> Event Address: </label>
                        <input type="text" name="event_address" required="required" maxlength="75" />


                    <label for="event_city"> Event City: </label>
                        <input type="text" name="event_city" required="required" maxlength="50" />

                    <label for="event_state"> Event State: </label>
                        <input type="text" name="event_state" required="required" maxlength="50" />
  
                    <label for="event_zip"> Event Zip Code: </label>
                        <input type="number" name="event_zip" required="required" maxlength="50" />
                    <input type="submit" value="Submit" />
            </form>
        </fieldset>
        <?php
    }
?>