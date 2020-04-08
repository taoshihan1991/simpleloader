<?php
require_once "loader.php";
$router=array(
    '^about\.'=>'single/index/about?id=1',
    '^laruence$'=>'index/index/memInfo',
    '^sysinfo$'=>'index/index/memInfo',
    '^uptime$'=>'index/index/uptime',
    '^\d+\.'=>'index/index/index'
);
$app=app::getInstance();
$app->bind('config',function(){
    return new conf\config();
});
$app->bind('pdo',function(){
    $config=\app::getInstance()->make('config');
    return new $config->db['class']($config->db);
});
if(php_sapi_name()!="cli"){
	$app->setRouter($router)
	->run();
}else{
	$swoole=new Swoole\Websocket\Server("0.0.0.0", 9505);
	$swoole->set([
    		'daemonize' => 1,
	]);
	$app->setRouter($router)
	->setSwoole($swoole)
	->run();
}
