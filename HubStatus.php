<?PHP

/*
CREATE TABLE IF NOT EXISTS `hubs` (
  `id` int(4) unsigned NOT NULL auto_increment,
  `Provider` text NOT NULL,
  `IPAddress` text NOT NULL,
  `Location` text NOT NULL,
  `MaximumServers` int(4) NOT NULL default '0',
  `status` enum('online','offline','inactive') NOT NULL default 'offline',
  `url` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

*/

	set_time_limit(900);

	function canConnect($server, $port){
		$return = @fsockopen($server, $port, $errno, $errst, 3);
		if($return){
			fclose($return);
			// $return = exec("ping -c3 $server");
			// $return = explode("/", $return);
			// $return = $return[4];
			// $total = "";
			// $total = exec("ping -c3 ".$_SERVER['REMOTE_ADDR']);
			// if(strpos($total, "/") > 0){
			//	$total = explode("/", $total);
			//	$return = $return + $total[4];
			//}
			$return = true;
			return $return;
		}else{
			return false;
		}
		return NULL;
	}
	// Lobby server goes at the bottom, so it's at the top of the list during sorting :)
	// Connect to your DB here
	$servers = mysql_query("SELECT * FROM `hubs` WHERE `status` != 'inactive'");
	if(mysql_numrows($servers) == 0) exit;
	

	$output = "";
	$echoed = "";
	// Test them all
	$port = 5758;
	
	while($server = mysql_fetch_assoc($servers)){
		// Explode each serves details, and seom some details
		$response = false;
		$name = isset($urls[strtolower($server['providor'])]) ? $server['Location']." (<a href='".$server['url']."'>".$server['Providor']."</a>)" : $server['Location']." (".$server['Providor'].")";
		echo "Trying: ".$server['Location'];
		$answer = canConnect($server['IPAddress'], $port);
		$response = ($answer != false) ? $answer."ms"  : false;
		
		// Put this server at the top of the list if it worked, or the bottom if it didn't
		if($response != false){
			mysql_query("UPDATE `hubs` SET `status` = 'online' WHERE `id` = '".$server['id']."'");
			echo " - Success!<br/>";
		}else{
			mysql_query("UPDATE `hubs` SET `status` = 'offline' WHERE `id` = '".$server['id']."'");
			echo " - fail<br/>";
		}
	}

