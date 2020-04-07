<?php
require_once "vendor/autoload.php";
require_once "loader.php";
$app=app::getInstance();
if(php_sapi_name()!="cli"){
	exit("error!");
}

$app->run();
