<?php

if(!isset($pagedir)){
	$pagedir="../";
}

require_once($pagedir . "libs/libsse/libsse.php");
require_once($pagedir . "config/config.php");

$debug=2;
$session = "556666";

define("DEBUG", $debug);	
if (DEBUG <= 0 ) {
	header('Content-Type: text/json; charset=UTF-8');
	error_reporting(E_ERROR);

} else {
	header('Content-type: text/html; charset=UTF-8');

}


$myFile = "config.json";
$arr_data = array(); // create empty array

try {

	//Get data from existing json file
	$jsondata = file_get_contents($myFile);
	
	// converts json data into array
	$arr_data = json_decode($jsondata, true);

} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}




$GLOBALS['data'] = new SSEData('file',array('path'=>'./data'));
$sse = new SSE();

$now = time();


if(isset($_POST['user']) && !isset($_POST['message'])){
	$data->set('user',   json_encode(array('msg'=>htmlentities($_POST['user']),   'time'=>time() )));

} else if(isset($_POST['session'],$_POST['command'])){
	if        ($_POST['command'] == 'adduser') {
		try{
			$sql ="";
			$sql .="INSERT INTO `" . $database_table_prefix . "user_active` SET";
			$sql .=" `session` = :session";
			$sql .=", `name` = :name ";
			$sql .=", `status` = 'stop' ";
			$sql .=", `time` = '0' ";
			$sql .=", `update` = UNIX_TIMESTAMP()";
			$sql .=";";
	
			$stmt = $dbh->prepare($sql);
	
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->bindParam(":name", $_POST['username']);
			$stmt->execute();
			
			$response = array();
			$response['command'] = 'adduser';
			$response['name'] = $_POST['username'];

			if ( intval($stmt->queryString) == 0) {
				$response['responsecode'] = 200;
				$data->set('command',json_encode(array('session'=>htmlentities($_POST['session']),'time'=>time(), 'command'=>$_POST['command'], 'username'=>$_POST['username'])));

			} else {
				$response['responsecode'] = 400;
			}
			echo json_encode($response);

			if (DEBUG >= 2 ) {
				echo $sql;
				echo "<br />\n";
				echo $stmt->queryString;
				echo "<br />\n";
				echo $stmt->errorCode();
				echo "\nPDO::errorInfo():\n";
				print_r($stmt->errorInfo());
			}
			
			$isauth = true;
	
		}catch(PDOException $e){
			echo $e->getMessage();
		}

	} else if ($_POST['command'] == 'deluser') {

		try{
			$sql ="";
			$sql .="DELETE FROM `" . $database_table_prefix . "user_active`";
			$sql .=" WHERE `session` = :session";
			$sql .=" AND `name` = :name ";
			$sql .=";";
	
			echo $sql;
			$stmt = $dbh->prepare($sql);
	
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->bindParam(":name", $_POST['username']);
			$stmt->execute();

//			echo $stmt->queryString;
//			echo "<br />\n";
//			echo $stmt->errorCode();
//			echo "\nPDO::errorInfo():\n";
//			print_r($stmt->errorInfo());
			$isauth = true;
	
	
		}catch(PDOException $e){
			echo $e->getMessage();
		}

		$data->set('command',json_encode(array('session'=>htmlentities($_POST['session']),'time'=>time(), 'command'=>$_POST['command'], 'username'=>$_POST['username'])));
	
	} else if ( ($_POST['command'] == 'wordrequeston') OR ($_POST['command'] == 'wordrequestoff') ) {
	
		try{
			$sql ="";
			$sql .="INSERT INTO `" . $database_table_prefix . "user_active` SET";
			$sql .=" `session` = :session";
			$sql .=", `name` = :name ";
			$sql .=" ON DUPLICATE KEY UPDATE ";
			if ($_POST['command'] == 'wordrequeston') {
				$sql .=" `wordrequest` = UNIX_TIMESTAMP() ";
			} else {
				$sql .=" `wordrequest` = 0";
			}
			$sql .=";";
	
			echo $sql;
			$stmt = $dbh->prepare($sql);
	
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->bindParam(":name", $_POST['username']);
			$stmt->execute();

			echo $stmt->queryString;
			echo "<br />\n";
			echo $stmt->errorCode();
			echo "\nPDO::errorInfo():\n";
			print_r($stmt->errorInfo());
			$isauth = true;
	
	
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	
		$data->set('command',json_encode(array('session'=>htmlentities($_POST['session']),'time'=>time(), 'command'=>$_POST['command'], 'username'=>$_POST['username'])));
		
	} else if ($_POST['command'] == 'timerstart') {
		
		try{
			$sql  ="";
			$sql .="UPDATE `" . $database_table_prefix . "user_active`";
			$sql .="SET `status` = 'stop'";
			$sql .=", `time` = `time` + time_to_sec( timediff( now( ) , from_unixtime( `update` ) ) ) ";
			$sql .=",`update` = UNIX_TIMESTAMP( ) ";
			$sql .="WHERE `session` = :session ";
			$sql .="   AND `status` = 'start'";
	
			if ($debug >= 1) {
				echo $sql;
				$stmt = $dbh->prepare($sql);
				$status = "start";
			}
	
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->execute();

			$sql ="";
			$sql .="INSERT INTO `" . $database_table_prefix . "user_active` SET";
			$sql .=" `session` = :session";
			$sql .=", `name` = :name ";
			$sql .=", `status` = 'start' ";
			$sql .=", `time` = :value ";
			$sql .=", `update` = UNIX_TIMESTAMP() ";
			$sql .=" ON DUPLICATE KEY UPDATE ";
			$sql .="  `status` = 'start' ";
			$sql .=", `time` = :value2 ";
			$sql .=", `wordrequest` = '0' ";
			$sql .=", `update` = UNIX_TIMESTAMP() ";
			$sql .=";";
	
			echo $sql;
			$stmt = $dbh->prepare($sql);
	
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->bindParam(":name", $_POST['username']);
			$stmt->bindParam(":value", $_POST['value']);
			$stmt->bindParam(":value2", $_POST['value']);
			$stmt->execute();
			echo $stmt->queryString;
			echo "<br />\n";
			echo $stmt->errorCode();
			echo "\nPDO::errorInfo():\n";
			print_r($stmt->errorInfo());
			$isauth = true;
	
	
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	
		$data->set('command',json_encode(array('session'=>htmlentities($_POST['session']),'time'=>time(), 'command'=>$_POST['command'], 'username'=>$_POST['username'], 'value'=>$_POST['value'])));
		
	} else if ($_POST['command'] == 'timerstop') {
		try{
			$sql ="";
			$sql .="SELECT * ";
			$sql .="FROM `" . $database_table_prefix . "user_active`";
			$sql .=" WHERE `session` = :session";
			$sql .=" AND `name` = :name ";
			$sql .=" AND `status` = :status ";
			$sql .=" LIMIT 1";
			$sql .=";";
	
			if ($debug >= 1) {
				echo $sql;
				$stmt = $dbh->prepare($sql);
				$status = "start";
			}

			$status="start";
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->bindParam(":name", $_POST['username']);
			$stmt->bindParam(":status", $status);
			$stmt->execute();

			while($row = $stmt->fetch()) {
				$id = $row['id'];
				$time = $row['time'];
				$update = $row['update'];
				
			}

			if ($debug >= 1) {
				echo $stmt->queryString;
				echo "<br />\n";
				echo $stmt->errorCode();
				echo "\nPDO::errorInfo():\n";
				print_r($stmt->errorInfo());
			}
			$isauth = true;
		
			$sql ="";
			$sql .="INSERT INTO `" . $database_table_prefix . "user_active` SET";
			$sql .=" `session` = :session";
			$sql .=", `name` = :name ";
			$sql .=" ON DUPLICATE KEY UPDATE ";
			$sql .=" `status` = 'stop' ";
			$sql .=", `time` = `time` + time_to_sec( timediff( now( ) , from_unixtime( `update` ) ) ) ";
			$sql .=", `update` = UNIX_TIMESTAMP() ";
			$sql .=";";
	

	
	
			echo $sql;
			$stmt = $dbh->prepare($sql);
			$tmp_status = "stop";
			$now = time();
			$tmp_time = $time + ($now - $update);
			
			$stmt->bindParam(":session", $_POST['session']);
			$stmt->bindParam(":name", $_POST['username']);
			$stmt->execute();
			echo $stmt->queryString;
			echo "<br />\n";
			echo $stmt->errorCode();
			echo "\nPDO::errorInfo():\n";
			print_r($stmt->errorInfo());
			$isauth = true;
	
	
		}catch(PDOException $e){
			echo $e->getMessage();
		}

		$data->set('command',json_encode(array('session'=>htmlentities($_POST['session']),'time'=>time(), 'command'=>$_POST['command'], 'username'=>$_POST['username'])));
		
	}
} else if(isset($_POST['session'],$_POST['deluser'])){
	$data->set('deluser',json_encode(array('session'=>htmlentities($_POST['session']),'time'=>time(), 'deluser'=>$_POST['deluser'])));

} else {

	class LatestUser extends SSEEvent {
		private $cache = 0;
		private $data;
		public function update(){
			return $this->data->msg;
		}
		public function check(){
			$this->data = json_decode($GLOBALS['data']->get('user'));
			if (!is_null($this->data)) {
				if($this->data->time !== $this->cache){
					$this->cache = $this->data->time;
					return true;
				}
			}
			
			return false;
		}
	};
	
	class LatestMessage extends SSEEvent {
		private $cache = 0;
		private $data;
		public function update(){
			return json_encode($this->data);
		}
		public function check(){
			$this->data = json_decode($GLOBALS['data']->get('message'));
			if (!is_null($this->data)) {
				if($this->data->time !== $this->cache){
					$this->cache = $this->data->time;
					return true;
				}
			}
			return false;
		}
	};
	
	class AddUser extends SSEEvent {
		private $cache = 0;
		private $data;
		public function update(){
			return json_encode($this->data);
		}
		public function check(){
			$this->data = json_decode($GLOBALS['data']->get('adduser'));
			if (!is_null($this->data)) {
				if($this->data->time !== $this->cache){
					$this->cache = $this->data->time;
					return true;
				}
			}
			return false;
		}
	};
	
	class DelUser extends SSEEvent {
		private $cache = 0;
		private $data;
		public function update(){
			return json_encode($this->data);
		}
		public function check(){
			$this->data = json_decode($GLOBALS['data']->get('deluser'));
			if (!is_null($this->data)) {
				if($this->data->time !== $this->cache){
					$this->cache = $this->data->time;
					return true;
				}
			}
			return false;
		}
	};
	
	class Command extends SSEEvent {
		private $cache = 0;
		private $data;
		public function update(){
			return json_encode($this->data);
		}
		public function check(){
			$this->data = json_decode($GLOBALS['data']->get('command'));
			if (!is_null($this->data)) {
				if($this->data->time !== $this->cache){
					$this->cache = $this->data->time;
					return true;
				}
			}
			return false;
		}
	};
	
	$sse->exec_limit = 30;
	
	$sse->sleep_time = 1;
	$sse->client_reconnect = 1;
	$sse->addEventListener('command',new Command());
	$sse->addEventListener('adduser',new AddUser());
	$sse->addEventListener('deluser',new DelUser());
	$sse->addEventListener('user',new LatestUser());
//	$sse->addEventListener('',new LatestMessage());
	$sse->start();

}