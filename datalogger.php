<?php

#phpinfo();

#var_dump(gd_info());

/*
Header( "Content-type: image/gif");

$image = imagecreate(200,200);
$maroon = imagecolorallocate($image, 100, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 0, 255);
$grey = imagecolorallocate($image, 200, 200, 200);

#Draw a rectangle
ImageFilledRectangle($image, 0, 0, 200, 200, $grey); 

#Output image
imagegif($image);

#Destroy image being stored in memory
imagedestroy($image);
*/


#Pull data from database
$database = new SQLite3('/home/pi/ece331/project2/templog.db');

$results = $database->query('SELECT * FROM temps');

while($row = $results->fetchArray()) {
	var_dump($row);
}


/*
header("Content-Type: image/png");
$im = @imagecreate(110, 20)
    or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate($im, 0, 0, 0);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  "A Simple Text String", $text_color);
imagepng($im);
imagedestroy($im);
*/
?>
