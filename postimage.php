<?php
include "sqlconnect.php";
include "includes/image.php";
set_time_limit(0);
function get_random_string($valid_chars, $length)
{
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}

$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "application/octet-stream"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
$name = "abcdefghijklmnopqrstuvwxyz123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$ranname = "".get_random_string($name, 12).".".$extension;
    if (file_exists("upload/" . $ranname))
      {
		exit;      
     }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $ranname);
	$fintime = time()+86400;
	mysql_query("INSERT INTO `pictures` (`picture`,`time`,`deletetime`) VALUES('".mysql_real_escape_string($ranname)."','".time()."','".$fintime."')");
$im = new ImageManipulator("upload/" . $ranname);

$im->resample(350,350,$constrainProportions = false); // takes care of out of boundary conditions automatically
$im->save("upload/m_" . $ranname);
	header("location: /".mysql_insert_id()."/");
	exit;
      }
    }
  }
else
  {
  echo "Invalid file";
  }
?>
