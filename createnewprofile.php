<?php 
			
include("config.php");


$username = $_POST["username"];
$password = $_POST["password"];
$rpassword = $_POST["rpassword"];
$zipcode = $_POST["zipcode"];
$party = $_POST["party"];
$age = $_POST["age"];

$sql = "INSERT INTO c_cs147_misslynn.users (username, password,zipcode, party, ageRange )". 
"VALUES ".
"( '$username', '$password','$zipcode', '$party','$age')";
$result=mysql_query($sql);
			
//header('Location: index.php');

?>