<?php

function random_string() {
    $character_set_array = array();
    $character_set_array[] = array('count' => 5, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => 5, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    
    shuffle($temp_array);
    return implode('', $temp_array);
}

	$temp = random_string();
    $inputImage = $_REQUEST['imageUrl'];	
    $pieces = explode("/", $inputImage);
    $outputImage = $pieces[0] . "/" . $pieces[1] . "/" . $temp . $pieces[2];
    $inputImage = trim($inputImage, "\n");
    $outputImage = trim($outputImage, "\n");
    $command = "./output $inputImage $outputImage";
    
    $params = $_REQUEST['param'];
    foreach ($params as $param) {
			$command = $command . " " . $param;
		}
	$fh = fopen("test.txt", 'w');
	fwrite($fh, $command);
  $output = system($command);
  echo $outputImage;
	// index.php?param[]=value1&param[]=value2&param[]=value3
	// param[0] of every function will contains its function_id (integer)
	// Then that function appends extra arguments if any are there
?>



