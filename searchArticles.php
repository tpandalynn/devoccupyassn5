<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
	
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
  
  <?php
		include("config.php");
	?>
  
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
	  
    <ul data-role="listview" data-inset="true" data-filter="true">
    
    <?php
    	include("config.php");
    	if(true){
    		$search=$_POST['SearchedWords']; 
    		
    		//$search = 'Washington';
    		$data = mysql_query("SELECT * FROM articles") or die(mysql_error()); 
  
    		//remember to add color coded images later <img src='images/redCircle.png' alt='Red'class='ui-li-icon ui-li-thumb'><span class='articleTitle'></span>		
	    		while($info = mysql_fetch_array($data)){
    			if( ($info['authors'] == $search) || ($info['source'] == $search) || ($info['title'] == $search) ){
    				echo "<li><a class='articleTitle' href='#' data-transition='slide'>".$info['title']."</a></li>";
    			}else{
    				$text = $info['title'];
    				$pos = strpos($text, $search);
    				if($pos !== false){
    					echo "<li><a href='http://stanford.edu/~jericson/cgi-bin/occupycongress/#p2'>".$info['title']."</a></li>";
    				}else{
    					$text = $info['author'];
    					$pos = strpos($text, $search);
    					if($pos !== false){
    						echo "<li><a href='http://stanford.edu/~jericson/cgi-bin/occupycongress/#p2'>".$info['title']."</a></li>";
    					}else{
    						$text = $info['articleText'];
    						$pos = strpos($text, $search);
    						if($pos !== false){
    							echo "<li><a href='http://stanford.edu/~jericson/cgi-bin/occupycongress/#p2'>".$info['title']."</a></li>";	
    						}else{
    							$text = $info['source'];
    							$pos = strpos($text, $search);
    							if($pos !== false)
    								echo "<li><a href='http://stanford.edu/~jericson/cgi-bin/occupycongress/#p2'>".$info['title']."</a></li>";
    						}
    					}
    				}
    			}
    			
    			
    		}
   
    	}else{
    		echo "<p>Please enter a search query.</p>";		
    	}
       
    ?>
    
    </ul>
    
    
    </div>
       
</body>
</html>










</html>