<?php 
	if(!isset($pagedir)){
		$pagedir="../";
	}
	
	require_once($pagedir . "libs/libsse/libsse.php");
	require_once($pagedir . "config/config.php");
	require_once($pagedir . "config/database_timer.php");

	
	$debug=0;
	$session = "556666";
	
	define("DEBUG", $debug);	
	if (DEBUG <= 0 ) {
		header('Content-Type: text/json; charset=UTF-8');
		error_reporting(E_ERROR);

	} else {
		header('Content-type: text/html; charset=UTF-8');

	}
	

	
	
/*
$settings=array();
array_push($settings,array("bgcolor", "#000000"));
array_push($settings,array("oncolor", "#c80000"));
array_push($settings,array("offcolor", "#280000"));
array_push($settings,array("sync", 1));
array_push($settings,array("offset2", 0));

echo json_encode(array("setting", $settings));
echo "<br />\n";
*/
	$fromfile = false;

	try{
		
		$sql ="";
		$sql .="SELECT count( * ) as count ";
		$sql .="FROM `" . $database_table_prefix . "user_active`";
		$sql .=" WHERE `session` = :session";
		$sql .=" AND `name` != '-=-=-=-TOP-=-=-=-'";
		$sql .=";";
	
		if ($debug >= 1) {
			echo $sql;
		}

		$stmt = $dbh->prepare($sql);
	
		$stmt->bindParam(":session", $session);
		$stmt->execute();
	
		$time= 0;
		$doupdate = false;
			
		$row = $stmt->fetch();
		if ($row['count'] <= 0) {
			$fromfile = true;		
		} 		
		
	}catch(PDOException $e){
		echo $e->getMessage();
	}


	if ($fromfile == true) {
		$myFile = "config.json";
		$arr_data = array(); // create empty array
	
		try {
			$jsondata = file_get_contents($myFile);
			$arr_data = json_decode($jsondata, true);
	
			foreach ($arr_data['users'] as $key => &$value){
				try{
					$sql ="";
					$sql .="INSERT INTO `" . $database_table_prefix . "user_active` SET";
					$sql .=" `session` = :session";
					$sql .=", `name` = :name ";
					$sql .=", `status` = 'stop' ";
					$sql .=", `time` = '0' ";
					$sql .=", `update` = UNIX_TIMESTAMP()";
					$sql .=";";
				
					if ($debug >= 1) {
						echo $sql;
					}
	
					$stmt = $dbh->prepare($sql);
					$status = "start";
				
					$stmt->bindParam(":session", $session);
					$stmt->bindParam(":name", $value['name']);
					$stmt->execute();
				
				}catch(PDOException $e){
					echo $e->getMessage();
				}
	
			}
			
			try{
				$sql ="";
				$sql .="REPLACE INTO `" . $database_table_prefix . "user_active` SET";
				$sql .=" `session` = :session";
				$sql .=", `name` = '-=-=-=-TOP-=-=-=-' ";
				$sql .=", `status` = 'stop' ";
				$sql .=", `time` = '0' ";
				$sql .=", `update` = UNIX_TIMESTAMP()";
				$sql .=";";
			
				if ($debug >= 1) {
					echo $sql;
				}

				$stmt = $dbh->prepare($sql);
				$status = "start";
			
				$stmt->bindParam(":session", $session);
				$stmt->execute();
			
			}catch(PDOException $e){
				echo $e->getMessage();
			}

	
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}

	$arr_data = array(); // create empty array
	
	$setting = array();
	$setting['bgcolor']  = "#000000";
	$setting['oncolor']  = "#00ff00";
	$setting['offcolor'] = "#070707";
	$setting['autosync'] = "true";
	$setting['offset2']  = "-55356000";
	$arr_data['setting'] = $setting;

	try{
		$sql ="";
		$sql .="SELECT `id`, `session`, `name`, `status`, `update`, `time`, `wordrequest`, `ddd`,";
		$sql .=" `time` + time_to_sec( timediff( now( ) , from_unixtime( `update` ) ) ) AS time2 ";
		$sql .="FROM `" . $database_table_prefix . "user_active`";
		$sql .=" WHERE `session` = :session";
		$sql .=";";
	
		if ($debug >= 1) {
			echo $sql;
		}

		$stmt = $dbh->prepare($sql);
		$status = "start";
	
		$stmt->bindParam(":session", $session);
		$stmt->execute();
		
		$arr_data['users'] = array();

		while($row = $stmt->fetch()) {
			if ($row['name'] == '-=-=-=-TOP-=-=-=-') {
				$top = array();
				$top['name'] = "TOP";
				$top['status'] = $row['status'];
				$top['time'] = $row['time'];
				$top['update'] = $row['update'];
				$arr_data['top'] = $top;
			
			} else {
				$user = array();
				$user['name'] =  $row['name'];
				$user['status'] = $row['status'];
				if ($row['status'] == 'start') {
					$user['time'] = $row['time2'];
				} else {
					$user['time'] = $row['time'];
				}
				$user['update'] = $row['update'];
				$user['wordrequest'] = $row['wordrequest'];
				array_push($arr_data['users'], $user);
			
			}
		}
	
	}catch(PDOException $e){
		echo $e->getMessage();
	}

	

	try {
		$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
		echo $jsondata;
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}



?>
