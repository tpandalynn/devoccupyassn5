<?php

include("config.php");

	$zip = $_POST['zip'];
	$sql="UPDATE c_cs147_misslynn.users SET zipcode='$zip' WHERE userID = 1";
	$result=mysql_query($sql);
	
	header('Location: settings.php');
?>