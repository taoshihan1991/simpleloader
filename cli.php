<?php
require_once "loader.php";
$app=app::getInstance();
$app->bind('config',function(){
    return new conf\config();
});
$app->bind('pdo',function(){
    $config=\app::getInstance()->make('config');
    return new $config->db['class']($config->db);
});

if(php_sapi_name()!="cli"){
	exit("error!");
}

$app->run();
