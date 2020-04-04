<?php
require_once "loader.php";
$router=array(
    '^about\.'=>'single/index/about?id=1',
    '^pig'=>'cmd/pig/getPigPrice'
);
$app=app::getInstance();
$app->bind('config',function(){
    return new conf\config();
});
$app->bind('pdo',function(){
    $config=\app::getInstance()->make('config');
    return new $config->db['class']($config->db);
});

$app->setRouter($router)
->setSwoole(new Swoole\Http\Server("0.0.0.0", 9505))
->run();
