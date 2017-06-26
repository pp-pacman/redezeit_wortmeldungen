<?php

if(!isset($pagedir)){
	$pagedir="../";
}

require_once($pagedir . "libs/libsse/libsse.php");
require_once($pagedir . "config/config.php");

$debug=0;
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

