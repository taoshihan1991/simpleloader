<?php
namespace Server;

use Log2\Log;
class Cron{
	private $second=0;
	private $tasks=array(
		array("duration"=>2,"method"=>"readLogs")
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
	static $curtime;
	public function readLogs(){
		$lines=Log::read();
		if(!$lines){
			return;
		}
		preg_match("/\[(.*)\]/i",$lines[0],$curtime);
		if(self::$curtime!=$curtime[1]){
			echo $lines[0]."\r\n";
			self::$curtime=$curtime[1];
		}
	}
}