<?php
namespace Controller\Client;

use Server\Cron as ServerCron;
class Cron{
	public function index(){
		$cron=new ServerCron();
		$cron->run();
	}
}