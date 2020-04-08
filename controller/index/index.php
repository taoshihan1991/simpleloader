<?php
namespace controller\index;


class index{
    public function index(){
		$sysinfo=$this->getSysinfo();
        return include ROOT."/view/index.php";
    }
    public function getList(){
	$list=array();
	}
	public function getSysinfo(){
		exec("/usr/bin/free -h",$output);
		return $output;
	}
	public function meminfo(){
		$data=$this->getSysinfo();
		//var_dump($data);
		return json_encode($data);
	}	
	public function uptime(){
		exec("/usr/bin/uptime",$output);
		return json_encode($output);
	}
    public function laruence(){
	$q="PHP7";
	$es=new \lib\es();
	$list=$es->search($q);	
        return include ROOT."/view/laruence.php";
    }
 
}
