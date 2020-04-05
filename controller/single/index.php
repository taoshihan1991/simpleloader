<?php
namespace controller\single;
class index{
        public function about(){
		$req=\app::getInstance()->getRequest();
		var_dump($_GET,$req);
                $tpl= include ROOT.'/view/single.php';
                return $tpl;
        }
}
