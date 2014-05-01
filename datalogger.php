<?php

#phpinfo();
#var_dump(gd_info());

#Declare offsets from begginning
$xoffset = 50;
$yoffset = 50;
$xlength = 720;
$ylength = 720;
$yscale = 18;


#Create original background image
Header( "Content-type: image/gif");
$image = imagecreate($xoffset+$xlength,$yoffset+$ylength+50);

#Prepare colors
$red = imagecolorallocate($image, 255, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 0, 255);
$grey = imagecolorallocate($image, 200, 200, 200);
$black = imagecolorallocate($image, 0, 0, 0);

#Draw title white space
ImageFilledRectangle($image, $xoffset, 0, $xoffset+$xlength, $yoffset, $white);
#Draw y axis white space
ImageFilledRectangle($image, 0, 0, $xoffset, $yoffset+$ylength, $white);
#Draw x axis white space
ImageFilledRectangle($image, 0, $yoffset+$ylength, $xoffset+$xlength, $yoffset+$ylength+50, $white);
#Draw background
ImageFilledRectangle($image, $xoffset, $yoffset, $xoffset+$xlength, $yoffset+$ylength, $grey); 
imagesetthickness($image, 5);
#Draw y axis
ImageLine($image,50,50,50,770,$black);
#Draw x axis
ImageLine($image,50,768,770,768,$black);
imagesetthickness($image, 1);
#Draw grid
$yaxinc = 5;
for($p = 0; $p < 8; $p++){
        ImageLine($image, $xoffset, $yoffset+(90*$p), $xoffset+$xlength, $yoffset+(90*$p), $black);
        ImageString($image, 5, $xoffset-25, $yoffset+(90*$p), $yaxinc*(8-$p), $black);
}
$xaxinc = 30;
for($m = 0; $m < 24; $m++){
	ImageLine($image, $xoffset+($xaxinc*$m), $yoffset+$ylength, $xoffset+($xaxinc*$m), $yoffset, $black);
        ImageString($image, 5, $xoffset+($xaxinc*$m), $yoffset+$ylength+10, $m, $black);
}
#Draw titles
$title = "Temperature Data Logger";
$ytitle = "Temperature (Celsius)";
$xtitle = "Time (Hours)";
ImageString($image, 5, 300, 25, $title, $black);
ImageStringUp($image, 5, 3, 450, $ytitle, $black);
ImageString($image, 5, 335, 795, $xtitle, $black);

#Pull data from database
$database = new SQLite3('/home/pi/ece331/project2/templog.db');
$results = $database->query('SELECT temp FROM temps DESC LIMIT 1440');
$timestamps = $database->query('SELECT timestamp FROM temps');

#var_dump(gettype($timestamps));

#Stores the number of rows of temperature data in 'num_rows'
$rows = $database->query("SELECT COUNT(*) as count FROM temps");
$row1 = $rows->fetchArray();
$num_rows = $row1['count'];

#var_dump($num_rows);

$xincrement = $xlength/1440;
$x=$xoffset;
$i=0;

#var_dump($xincrement);

//Loop while we still have rows of data
while($dataRow= $results->fetchArray()) {
	
	//Calculate y-coordinate
	$y = $dataRow[0];
	
	#var_dump($x);
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
	$error = ImageLine($image,$points[$i][0],(770-($points[$i][1]*$yscale)),$points[$i+1][0],(770-($points[$i+1][1]*$yscale)),$red);
}


//Output GIF and free memory
imagegif($image);

#Destroy image being stored in memory
imagedestroy($image);


?>
