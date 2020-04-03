<?php
namespace controller\notice;
class service{
        public function reviewService(){
            $tpl= require_once('./view/service.php');
		var_dump($tpl);
		return $tpl;
        }
}
