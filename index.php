<?php
//路由映射
$rules=array(
	'^user$'=>'User/User/getUserList',
	'^user\/(\d+)$'=>'User/User/getUserById/id/$1',
	'^user\/(\d+)\/article$'=>'User/User/getUserArticle/uid/$1',
	'^client\/user$'=>'Client/User/getUserList',
);
require_once "SimpleLoader.php";
SimpleLoader::run($rules);