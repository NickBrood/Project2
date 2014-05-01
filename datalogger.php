<?php

#phpinfo();

#var_dump(gd_info());

/*
Header( "Content-type: image/gif");

$image = imagecreate(720,720);

$red = imagecolorallocate($image, 255, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 0, 255);
$grey = imagecolorallocate($image, 200, 200, 200);


#Draw a rectangle
ImageFilledRectangle($image, 0, 0, 720, 720, $grey); 
*/

#Pull data from database
$database = new SQLite3('/home/pi/ece331/project2/templog.db');
$results = $database->query('SELECT temp FROM temps');
$timestamps = $database->query('SELECT timestamp FROM temps');

#Stores the number of rows of temperature data in 'num_rows'
$rows = $database->query("SELECT COUNT(*) as count FROM temps");
$row1 = $rows->fetchArray();
$num_rows = $row1['count'];

#Parse Timestamp for useful numbers
$minutes = $database->query('SELECT strftime("%M", time(timestamp)) FROM temps');
$hours = $database->query('SELECT strftime("%H", time(timestamp)) FROM temps');
$day = $database->query('SELECT strftime("%d", time(timestamp)) FROM temps');
$dayofweek = $database->query('SELECT strftime("%w", time(timestamp)) FROM temps');

$minutes = intval($minutes);

var_dump($minutes);
var_dump($hours);
var_dump($day);
var_dump($dayofweek);


#var_dump($num_rows);

$xincrement = bcdiv(720, $num_rows-1,0);
$x=0;
$i=0;

#var_dump($xincrement);

//Loop while we still have rows of data
while($dataRow= $results->fetchArray()) {
	
	//Calculate y-coordinate
	$y = $dataRow[0];
	
#	var_dump($x);
#	var_dump($y);

	//Add values into points array
	$points[$i][0] = $x;
	$points[$i][1] = $y;
	
#	var_dump(gettype($points[$i][0]));
#	var_dump(gettype($points[$i][1]));

	//Increment x by xincrement
	$x+=$xincrement;
	$i++;
}

for($i=0;$i<$num_rows-1;$i++){
	#var_dump($points[$i][0]);
	#var_dump($points[$i][1]);
#	$error = ImageLine($image,$points[$i][0],720-$points[$i][1],$points[$i+1][0],720-$points[$i+1][1],$red);
#	imageline($image, 0, 0, 200, 200, $red);
}

/*
//Output GIF and free memory
imagegif($image);

#Destroy image being stored in memory
imagedestroy($image);
*/
?>
