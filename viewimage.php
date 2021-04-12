<?php
if($_GET['id'] == ""){
	exit;
}
if(!is_numeric($_GET['id'])){
	exit;
}
if(strpos($_GET['id'], "/")){
	exit;
}
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
	<link rel="stylesheet" href="http://scrachwall.com/style/global.css">
</head>

<body>
<header>
	<div class="logo">
		<a href="/"><- Back To Scrachwall</a>
	</div>
</header>
<div class="content">
	<section class="feed">
		<?php
			$query = mysql_query("SELECT * FROM `pictures` WHERE `id`='".mysql_real_escape_string($_GET['id'])."' ORDER BY `time` ASC");
			$fetch = mysql_fetch_array($query);
				print "<div class=\"image_full\" id=\"".$fetch['id']."\">";
				print "<h1> Original Image </h1>";
					print "<a href=\"http://scrachwall.com/upload/".$fetch['picture']."\"><img src=\"http://scrachwall.com/upload/".$fetch['picture']."\"></a><br />";
					$time = time() - $fetch['time'];
					$hours = $time / 3600;
					if($hours < 1){
						print "Uploaded less than an hour ago.";
					}
					else{
						print "Uploaded ".intval($hours)." hours ago.";
					}
				print "</div>";
			print "<div class=\"comment\">";
				print "<h2>Comments</h2><br />";
				print "<button draggable=\"true\" id=\"imageDrop\" onclick=\"document.getElementById('upload').click()\" title=\"Click\">Upload image</button>";
			print "<form method=\"POST\" action=\"/comment.php?id=".$fetch['id']."\" enctype=\"multipart/form-data\" id=\"form\">";
			print "<input type=\"file\" name=\"file\" class=\"file\" id=\"upload\" accept=\"image/*\"><br />";
			print "</form>";
			$query = mysql_query("SELECT * FROM `comments` WHERE `main`='".mysql_real_escape_String($_GET['id'])."' ORDER BY `time` ASC");
			while($fetch = mysql_fetch_array($query)){
				print "<div class=\"image\" id=\"".$fetch['id']."\">";
					print "<a href=\"/upload/".$fetch['picture']."\"><img src=\"/upload/m_".$fetch['picture']."\"></a>";
				print "</div>";
			}
			print "<br />";
			print "</div>";
		?>
	</section>
</div>
</body>
<script type="text/javascript">
document.getElementById("upload").onchange = function() {
    document.getElementById("imageDrop").textContent= "Uploading...";
    document.getElementById("form").submit();
};
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
</html>
