<?php
	session_start();
	session_destroy();
	header("Location:title_page.php");
?>