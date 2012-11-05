<?php 
			
include("config.php");

$password = $_POST["password"];
$rpassword = $_POST["rpassword"];
$party = $_POST["party"];
$age = $_POST["age"];

//echo "password ".$_POST['password']." </h2>";

$sql="UPDATE c_cs147_misslynn.users SET password='$password', party='$party', ageRange='$age' WHERE userID = '1'";
$result=mysql_query($sql);

header('Location: updatedprofile.php');

?>
			