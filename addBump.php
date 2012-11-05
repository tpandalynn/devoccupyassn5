

	<?php
	
	include("config.php");
	
	$cID = $_POST["commentID"];
	
	$q1 = sprintf("SELECT commentID, userID FROM bumps WHERE commentID=%d and userID=%d", $cID, 7);
	$result = mysql_query($q1);
	$toReturn = 0;
	
	if($result) {
		$rowCheck = mysql_num_rows($result);
		
		if($rowCheck==0) {
			//userID = 7 for this example;
			$q2 = sprintf("INSERT INTO bumps (commentID, userID) VALUES (%s, %s)", $cID, 7);
			$result = mysql_query($q2);
			$toReturn = $cID;
		} else {
			$toReturn = -1;
		}
		
		echo $toReturn;
	} 
	
	else {
		echo("Problem: " . $q1);
	}
	

	?>
		