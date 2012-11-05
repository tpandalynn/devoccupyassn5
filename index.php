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
	<link rel="apple-touch-startup-image" href="startup.png">
	
  <link rel="stylesheet" href="my.css" />
  <link rel="stylesheet" href="own.css" />
  
  <script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
  <!--<script src="my.js"></script>-->
  
  <?php
		include("config.php");
	?>
	
	<script type="text/javascript">
	
	var articleData = new Array();
	var commentData = new Array();
	var currentArticleID = 2;
	var numClicks = 0;
	
	$(function() {
		$.getJSON("getArticles.php", function(json) {
			
			//console.log(json);
			
			for(i=0; i<json.ARTICLES.length; i++) {
				$("span.articleTitle").eq(i).html(json.ARTICLES[i].title);
				
				aID = json.ARTICLES[i].articleID;
				
				$("a.articleTitle").eq(i).data("articleID", aID);

				articleData[aID] = new Array();
				commentData[aID] = new Array();
				
				articleData[aID]["Source"] = json.ARTICLES[i].source;
				articleData[aID]["Date"] = json.ARTICLES[i].date;
				articleData[aID]["Authors"] = json.ARTICLES[i].authors;
				articleData[aID]["Date"] = json.ARTICLES[i].date;
				articleData[aID]["ArticleText"] = json.ARTICLES[i].articleText;
				articleData[aID]["Link"] = json.ARTICLES[i].link;
			}
			
			for(i=0; i<json.COMMENTS.length; i++) {
				aID = json.COMMENTS[i].articleID;
				
				commentArray = new Array();
				
				commentArray["CommentID"] = json.COMMENTS[i].commentID;
				commentArray["Comment"] = json.COMMENTS[i].comment;
				commentArray["NumBumps"] = json.COMMENTS[i].numBumps;
				
				commentData[aID].push(commentArray);
			}
			
			console.log(commentData);
			
			
			$().doRest();
			
		});
		
		
		//Set Source
		jQuery.fn.doRest = function() {
			
			//RATE
			$("#rateButton").click(function() {
				alert("Thanks!");
			});
			
			//CLICK DISPLAY HIGHLIGHTED REGIONS
			$("button#displayHighlights").click(function() {
				//$("div#articleFull p").eq(2).css("background-color", "yellow");
				$("div#articleFull p").eq(currentArticleID).css("background-color", "yellow");
				
				$(this).parent().hide();
				$("button#removeHighlights").parent().show();
			});
			
			$("button#removeHighlights").click(function() {
				console.log("HERE");
				//$("div#articleFull p").eq(2).css("background-color", "white");
				$("div#articleFull p").eq(currentArticleID).css("background-color", "white");
				
				$(this).parent().hide();
				$("button#displayHighlights").parent().show();
			});
			
			//CLEAR HIGHLIGHTS
			$("a#readMoreButton").click(function() {
				$("div#articleFull p").eq(2).css("background-color", "white");
				
				if(numClicks==0) {
					console.log("OK");
				}
				
				if(numClicks>0) {
					$("button#displayHighlights").parent().show();
					$("button#removeHighlights").parent().hide();
				}
				numClicks++;
			});
			
			
			//CLICK AN ARTICLE
			$("a.articleTitle").click(function() {
				articleID = $(this).data("articleID");
				currentArticleID = articleID;
				
				//Fill in Source Text
				$("h3#source").html(articleData[articleID]["Source"]);
				
				var t = articleData[articleID]["ArticleText"];
				var pattern = /<p>|<\/p>/g;
				var sp = t.split(pattern);
				
				//Maybe add better logic here?
				var st = "<p>" + sp[1] + "</p>";
				
				//Fill in article preview
				$("div#articlePreview").html(st);
				
				//Fill in full article
				$("div#articleFull").html(t);
				
				//Fill in comments
				c1 = "";
				c2 = "";
				
				$("div#popularComments").html("");
				
				//Bump Buttons - Add Text to Span Elements
				if(commentData[articleID][0] != null) {
					$("span#c1t").text(commentData[articleID][0]["Comment"]);
					$("span#c1").text(commentData[articleID][0]["NumBumps"]);
				}
				
				if(commentData[articleID][1] != null) {
					$("span#c2t").text(commentData[articleID][1]["Comment"]);
					$("span#c2").text(commentData[articleID][1]["NumBumps"]);
				}
				
				//Remove Data and Add Data (the comment ID) - so you can query with it!
				jQuery.removeData($("span#c1"), "commentID");
				$("span#c1").data("commentID", commentData[articleID][0]["CommentID"]);
				jQuery.removeData($("span#c2"), "commentID");
				$("span#c2").data("commentID", commentData[articleID][1]["CommentID"]);

				//Reset buttons
				$("button.bumpButton").removeClass("ui-disabled");
				$("button.bumpButton").unbind("click");
				
				$("button.bumpButton").click(function() {
					cID = "";
					$(this).addClass("ui-disabled");
					
					if($(this).hasClass("comment1")) {
						cID = $("span#c1").data("commentID");
					}
					
					if($(this).hasClass("comment2")) {
						cID = $("span#c2").data("commentID");
					}

					
					//post here
					$.post("addBump.php", {commentID: cID}, function(data) {
						data = data.trim();
						//console.log("DATA BACK: " + data);
						
						//Has not already bumped this comment
						if(data>0) {
							if($("span#c1").data("commentID")==data) {
								$("span#c1").text((parseInt($("span#c1").text())+1));
								commentData[currentArticleID][0]["NumBumps"]++;
							}
							if($("span#c2").data("commentID")==data) {
								$("span#c2").text((parseInt($("span#c2").text())+1));
								commentData[currentArticleID][1]["NumBumps"]++;
							}
						}
						else {
							alert("Already Bumped This Comment");
						}	
					});
					 
				});
			
			
			});
			
			
			
			

			
		};
		
		
		
		
	});
	
	</script>
  
</head>
  


<body>

<!-- Start of first page: #p1 -->
  <div data-role="page" id="p1">
  	<div data-role="header" data-theme="b">
  		<h3>OccupyCongress</h3>

  		<a data-role="button" href="createprofile.php" data-rel="dialog" data-transition="pop" class="ui-btn-left" id="gear" data-icon="button" >
       Create Profile
      </a>
      <a data-role="button" href="settings.php" data-transition="flip" class="ui-btn-right" id="gear" data-icon="gear" >
        Settings
      </a>
    </div>
    
    <div data-role="content">
      <ul data-role="listview" data-divider-theme="b" data-inset="true">
        <li data-role="list-divider" role="heading">Trending Op-Eds</li>
        <li>
          <a class="articleTitle" href="#p2" data-transition="slide">
	          <img src="images/redCircle.png" alt="Red"class="ui-li-icon ui-li-thumb">
	          <span class="articleTitle"></span>
          </a>
        </li>
        <li>
          <a class="articleTitle" href="#p2" data-transition="slide">
	          <img src="images/greenCircle.png" alt="Red"class="ui-li-icon ui-li-thumb">
	          <span class="articleTitle"></span>
          </a>
        </li>
        <li>
          <a class="articleTitle" href="#p2" data-transition="slide">
	          <img src="images/greenCircle.png" alt="Red"class="ui-li-icon ui-li-thumb">
	          <span class="articleTitle"></span>
          </a>
        </li>
        <li>
          <a class="articleTitle" href="#p2" data-transition="slide">
	          <img src="images/greenCircle.png" alt="Red"class="ui-li-icon ui-li-thumb">
	          <span class="articleTitle"></span>
          </a>
        </li>
        <li>
          <a class="articleTitle" href="#p2" data-transition="slide">
	          <img src="images/greenCircle.png" alt="Red"class="ui-li-icon ui-li-thumb">
	          <span class="articleTitle"></span>
          </a>
        </li>
      </ul>
      
    </div>
      
    <div data-role="footer" data-position="fixed" data-theme="b">
     	<form action="searchArticles.php" method="post">
			<input type="text" name ="SearchedWords" placeholder="Search Articles..."><br>
			<input type="submit" value="Submit">
		</form>
    </div>
  </div><!-- /page 1 -->
  
  
  <!-- Start of second page: #p2 -->
  <div data-role="page" id="p2" data-add-back-btn="true">
  	<div data-role="header"  data-theme="b">
  		<h3>Op-Ed View</h3>

      <a data-role="button" href="settings.php" data-transition="flip" class="ui-btn-right" id="gear" data-icon="gear">
        Settings
      </a>
    </div>
    
    <div data-role="content">
 
	    <h3 id="source"></h3>
	    
	    <div id="articlePreview">Article Preview Text</div>
	    
	    <!--<p>If we're serious about restoring government  of, by and for the people, we need to get big money out of our elections.</p>

			<p>From the Watergate era through the early 2000s, Congress and state legislatures passed campaign finance laws designed to limit the influence of corporations and wealthy donors on elections and public officials.  The system was less than perfect, but it has been decimated...</p></div>
			-->
			
			<p><a href="#p3" id="readMoreButton" data-role="button" data-inline="true" data-transition="slide">Read More</a>
			<a href="#commentsPopup" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop">Comment</a></p>
			
			<p style="text-decoration:underline">How much do you agree with the article?<br/></p>
			
			<div id="rateButton" data-role="controlgroup" data-type="horizontal">
				<a href="#" data-role="button">None</a>
				<a href="#" data-role="button">Little</a>
				<a href="#" data-role="button">Somewhat</a>
				<a href="#" data-role="button">Mostly</a>
				<a href="#" data-role="button">All</a>
			</div>
			
				
			
			<h3>Most Popular Comments</h3>
			
			
			
			<div id="popularComments"></div>
			<!--Comments Go Here-->
			<p>+<span id="c1"></span>&nbsp;<span id="c1t"></span>
					<button class='comment1 bumpButton' data-inline='true'>+1</button></p>
			<p>+<span id="c2"></span>&nbsp;<span id="c2t"></span>
					<button class='comment2 bumpButton' data-inline='true'>+1</button></p>
			
					
					
			
    </div>
    
      
    <div data-role="footer" data-position="fixed" data-theme="b">
     	<form action="searchComments.php" method="post">
			<input type="text" name ="commentSearch" value="Search Comments..."><br>
			<input type="submit" value="Submit">
		</form>
    </div>
  </div> <!-- /page 2 -->
  
  
  
  
  
    <!-- Start of second page: #p3 -->
  
  <div data-role="page" id="p3" data-add-back-btn="true">
  	<div data-role="header"  data-theme="b">
  		<h3>Reading Mode</h3>

      <a data-role="button" href="settings.php" data-transition="flip" class="ui-btn-right" id="gear" data-icon="gear">
        Settings
      </a>
    </div>
    
    <div data-role="content">

		  <h3 id="source"></h3>
		  
		  <button id="displayHighlights">Display Highlighted Regions</button>
		  <button id="removeHighlights">Remove Highlighted Regions</button>
		  
		  <div id="articleFull">Article Full</div>
	  </div>
	  
 </div><!-- /page 3 -->
 
 <!-- Comments -->
 <div data-role="page" id="commentsPopup">

		<div data-role="header" data-theme="e">
			<h1>Comment</h1>
		</div>

		<div data-role="content" data-theme="d">	
			<h2>Comment</h2>
			<p>Share your thoughts:</p>
			<textarea></textarea>
				
			<ul data-role="controlgroup" data-type="horizontal" class="localnav ui-corner-all ui-controlgroup ui-controlgroup-horizontal"><div class="ui-controlgroup-controls">
					<li data-role="button" data-transition="fade" class="ui-btn-active ui-btn ui-corner-left ui-btn-up-c" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c"><span class="ui-btn-inner ui-corner-left"><span class="ui-btn-text">Make Public</span></span></li>
					<li data-role="button" data-transition="fade" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" class="ui-btn ui-btn-up-c"><span class="ui-btn-inner"><span class="ui-btn-text">Send Private</span></span></li>
				</div></ul>
				
			<p><a href="#two" data-rel="back" data-role="button" data-inline="true" data-icon="back">Submit</a></p>	
		</div>
	</div>

  
</body>

</html>