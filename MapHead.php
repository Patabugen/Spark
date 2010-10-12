<?php
function file_chop($file_path, $chunk_size){ 
    $handle = @fopen($file_path, 'rb');         //read the file in binary mode 

    if($handle == 0){
	return false;
    }
    $size = filesize($file_path);  
    $contents = fread($handle, $size); 
    fclose($handle); 

    //find number of full $chunk_size byte portions 
    $num_chunks = floor($size/$chunk_size); 

    $chunks = array(); 

    $start = 0; 
    for ($kk=0; $kk < $num_chunks; $kk++){ 
      $chunks[] = substr($contents, $start, $chunk_size); //get $chunk_size bytes at a time 
      $start += $chunk_size; 
    } 
     
    if ($start < $size){ 
       $chunks[] = substr($contents, $start);  //get any leftover 
    } 
    return $chunks; 
}  

	// Reading Map Settings
	$settings = file_chop($_FILES['mapfile']['tmp_name'],1);
	// Numeric Values
	$maxplayers = ord($settings[9]);
	$holdtime = ord($settings[10]);
	$teams = ord($settings[11]);
	$powerups = ord($settings[21]);
	
	// Enabled/Disabled values
	$missile = ord($settings[16]);
	$nade = ord($settings[17]);
	$bouncy = ord($settings[18]);
	
	// High/Low
	$laser = ord($settings[13]);
	$special = ord($settings[14]);
	$recharge = ord($settings[15]);
	
	// Game Type
	$objective = ord($settings[12]);
	
	$namestart = 29;
	$namelen = ord($settings[($namestart - 2)]);
	for($i = ($namestart); $i < ($namestart + $namelen); $i++){
		$bname .= $settings[$i];
	}
	$name = addslashes($name);
	
	$deslen = ord($settings[$i]);
	$desstart = $i + 2;
	for($i = $desstart; $i < ($desstart + $deslen); $i++){
		$description .= $settings[$i];
	}
	$description = htmlentities($description, ENT_QUOTES);
	// End of Settings Reading
	$description = '';
	
	$name = strtolower($_FILES['mapfile']['name']);
	$name = substr($name,0, strlen($name) - 4);
	$name = addslashes($name);
