<!DOCTYPE html> 
<html>

<head>
	<title>OccupyCongress | Settings</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="appicon.png" />
	<link rel="apple-touch-startup-image" href="startup.png">
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>

</head> 	


<?php
include("config.php");
?>

	<body>

<!-- Start of page: #updateInfo -->
<div data-role="page" id="updateInfo">
	<div data-role="header" data-theme="e">
			<h1>Update</h1>
	</div>

		<div data-role="content" data-theme="d">	
			<h2>Update Your Information</h2>
			
			<form action="updateprofile.php" method="post">
				<div data-role="fieldcontain">
<!-- 
					<p>Hello, binderz123</p>
					<p>New Password:<input style="width:50%" type="password" name="password" id="password" value=""/></p>
					<p>Repeat Password:<input style="width:50%" type="password" name="rpassword" id="rpassword"/></p>
 -->
					
					<p>Party:
					<select name="party">
					<option value="Democratic">Democratic</option>
					<option value="Republican">Republican</option>
					<option value="Other">Other</option>
					</select></p>
					
					<p>Age Range:
					<select name="age">
					<option value="Under 21">Under 21</option>
					<option value="21-25">21-25</option>
					<option value="26-30">26-30</option>
					<option value="31-35">31-35</option>
					<option value="36-40">36-40</option>
					<option value="41-45">41-45</option>
					<option value="46-50">46-50</option>
					<option value="51-55">51-55</option>
					<option value="56-60">56-60</option>
					<option value="61-65">61-65</option>
					<option value="Over 65">Over 65</option>
					</select></p>
					<button data-inline="true">Update!</button></p> 
			</form>

			
			</div>
		</div>
</div>

</body>
 </html> 