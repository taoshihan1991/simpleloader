<?php
require_once "loader.php";
$router=array(
    '^notice\/review$'=>'notice/service/reviewService',
    '^pig'=>'cmd/pig/getPigPrice'
);
app::getInstance()->bind('config',function(){
    return new conf\config();
});
app::getInstance()->bind('pdo',function(){
    $config=\app::getInstance()->make('config');
    return new $config->db['class']($config->db);
});
app::getInstance()->setRouter($router)->run();
