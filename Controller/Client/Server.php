<?php
namespace Controller\Client;

use Server\Cron as ServerCron;
class Server{
	public function startHttp(){
		$socket=new \Server\Socket();
		$socket->create();
	}

	public function startLog(){
		$cron=new ServerCron();
		$cron->run();
	}
}