<?php
require_once("curl.php");

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

function getIP(){
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

function webUpload($imageurl){
	//$file = fopen("temp.txt", 'w');
	//fwrite($file, strstr("iitb.ac.in", $imageurl));
    if(preg_match("/iitb.ac.in/i", $imageurl)){
		
		$image = setCurlNoProxy($imageurl);
		
	}
	else{
		$image = setCurl($imageurl);
	}
    $ip = getIP();
    $imageName = random_string() . ".jpg";
    $saveLocation = "uploads/web/"  . $ip . "-" . $imageName;
    file_put_contents($saveLocation, $image);
    echo $saveLocation;
}

function localUpload(){
    $target_path = "uploads/local/";
    $ip = getIP();
    $target_path = $target_path  . $ip . "-" .  str_replace(" ", "_",  basename( $_FILES['localimage']['name'])); 
    if(move_uploaded_file($_FILES['localimage']['tmp_name'], $target_path)) {
        echo $target_path;
    } else{
        echo "There was an error uploading the file, please try again!";
    }
}
function camUpload(){
    $filteredData=substr($GLOBALS['HTTP_RAW_POST_DATA'], strpos($GLOBALS['HTTP_RAW_POST_DATA'], ",")+1);
    $image=base64_decode($filteredData);
    $ip = getIP();
    $imageName = random_string() . ".jpg";
    $saveLocation = "uploads/cam/"  . $ip . "-" . $imageName;
    file_put_contents($saveLocation, $image);
    echo $saveLocation;
}


	$webimgurl = $_POST['imageUrl'];
	if($webimgurl){
    webUpload($webimgurl);
	}

	$localimgurl = $_FILES['localimage'];
	if($localimgurl){
			localUpload();
	}

	$camimgurl = $_FILES['camimage'];
	if($GLOBALS['HTTP_RAW_POST_DATA']){
			camUpload();
	}

?>

