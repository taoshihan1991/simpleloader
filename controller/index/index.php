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
}
