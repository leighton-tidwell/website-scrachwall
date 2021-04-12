<?php
include "sqlconnect.php";
?>
<!DOCTYPE html>
<html>
<head>
<!--
=======================================
=======	Scrach Wall Source Code =======
======= Written by: Lil T       =======
======= You ready to admire?    =======
=======================================
-->
	<title>Scrach Wall - Random Image Board</title>
	<meta name="description" content="The random, original, anonymous image board.">
	<meta name="keywords" content="image,imageboard,notext,scrachwall,scrach,wall">
	<meta name="language" content="English" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="stylesheet" href="style/global.css">
</head>

<body>
<div id="container">
    <div id="left_float">
        <div id="logo">
            <form method="POST" action="postimage.php" enctype="multipart/form-data" id="form">
				<input type="file" name="file" class="file" id="upload" accept="image/*"><br />
                <input style="visibility:hidden;" id="imageDrop" value="Upload" type="submit">
			</form>
        </div>
        <!--
        <canvas id="swcanvas" height="200px" width="400px"></canvas><br />
        <div id="palete">
				<div id="black" class="colorblock">
				</div>
				<div id="white" class="colorblock">
				</div>
				<div id="blue" class="colorblock">
				</div>
				<div id="green" class="colorblock">
				</div>
				<div id="red" class="colorblock">
				</div>
		</div>
        -->
       <a href="javascript: alert('Scrachwall is the original, random image board');">About</a> &nbsp; | &nbsp;Copyright &copy; Scrachwall 2014
    </div>    
    <div id="feed">
        <?php
			$query = mysql_query("SELECT * FROM `pictures` ORDER BY `time` DESC");
			if(mysql_num_rows($query) == 0){
					print "All images have been deleted. Post some shit bruh.";
			}
			while(($fetch = mysql_fetch_array($query)) != NULL){
				print "<div id=\"".$fetch['id']."\" class=\"feeditem\">";
				print "<a href=\"/".$fetch['id']."/\">";
				print "<img class=\"feedimage\" data-original=\"http://scrachwall.com/upload/m_".$fetch['picture']."\" height=\"350px\" width=\"350px\"\">";
				print "</a>";
				print "</div>";
			}
		?>
    </div>
</div>
<div class="clear"></div>







</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript" src="static/canvas.js"></script>
<script type="text/javascript" src="includes/lazyload.js"></script>
<script type="text/javascript">
document.getElementById("upload").onchange = function() {
    document.getElementById("imageDrop").textContent= "Uploading...";
    document.getElementById("form").submit();
};
$("img.feedimage").lazyload({
    effect : "fadeIn"
});
</script>
<script type="text/javascript">$(document).ready(function() { sw_canvas_init(); });</script>
</html>
