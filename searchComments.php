<!DOCTYPE html>
<html>
	
	
<head>

	<title>OccupyCongress</title>
	
  <meta charset="utf-8" />
  <meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
  <link rel="apple-touch-icon" href="appicon.png" />
	//<link rel="apple-touch-startup-image" href="startup.png">
	
  <link rel="stylesheet" href="my.css" />
  <link rel="stylesheet" href="own.css" />
  
  <script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
  <!--<script src="my.js"></script>-->
 
</head>

<body>

<<!-- Start of page: #search -->
  <div data-role="page" id="searchArticles" data-add-back-btn="true">
  	<div data-role="header"  data-theme="b">
  		<h3>Search</h3>

      <a data-role="button" href="settings.php" data-transition="flip" class="ui-btn-right" id="gear" data-icon="gear" >
        Settings
      </a>
    </div>
    
        <!-- Start Searching for matches on database server. -->
        
        <div data-role="content">
        
        <h3>Search Results</h3>
	  

    <?php
    	include("config.php");
    	if(true){
    		//edit to sort by numBumps
    		$search=$_POST['commentSearch']; 
    		$comments = false; 
    		$data = mysql_query("SELECT * FROM comments") or die(mysql_error());
    		$articleData = mysql_query("SELECT * FROM articles") or die(mysql_error()); 
    		while($info = mysql_fetch_array($data)){
    			$text = $info['comment'];
    			$pos = strpos($text, $search);
    				if($pos !== false){
    					echo "<p>".$info['title']."</p>";
    					echo "<p>+".$info['numBumps']." ".$info['comment']." </p>";
    					$comments = true;	
   					}
    		}
    		if(!$comments)	
    			echo "<p>No matches exist.</p>";	
    	}
    
    ?>
    
	
     </div>
       
</body>
</html>