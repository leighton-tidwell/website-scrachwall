<?php
include "sqlconnect.php";
$query = mysql_query("SELECT * FROM `pictures` WHERE `deletetime`<'".time()."'");
while($fetch = mysql_fetch_array($query)){
	unlink("upload/".$fetch['picture']."");
	unlink("upload/m_".$fetch['picture']."");
}
mysql_query("DELETE FROM `pictures` WHERE `deletetime`<'".time()."'");

$query = mysql_query("SELECT * FROM `comments` WHERE `deletetime`<'".time()."'");
while($fetch = mysql_fetch_array($query)){
	unlink("upload/".$fetch['picture']."");
	unlink("upload/m_".$fetch['picture']."");
}
mysql_query("DELETE FROM `comments` WHERE `deletetime`<'".time()."'");
?>
