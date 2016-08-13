<?php
namespace Server;

class Cron{
	private $second=0;
	private $tasks=array(
		array("duration"=>5,"method"=>"doSomething"),
		array("duration"=>6,"method"=>"doSomething2"),
	);
	public function __construct(){

	}
	public function run(){
		while (true) {
			sleep(1);
			$this->second++;
			foreach($this->tasks as $task){
				if($this->second%$task['duration']==0){
					$this->$task['method']();
				}
			}
		}		
	}
	public function doSomething(){
		echo "[".date("Y-m-d H:i:s",time())."] doSomething1 ok!\r\n";
	}
	public function doSomething2(){
		echo "[".date("Y-m-d H:i:s",time())."] doSomething2 ok!\r\n";
	}
}