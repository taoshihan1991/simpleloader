<?php
class Router{
	public static function getRules(){
		//路由映射
		return array(
			'^user$'=>'User/User/getUserList',
			'^user\/(\d+)$'=>'User/User/getUserById/id/$1',
			'^user\/(\d+)\/article$'=>'User/User/getUserArticle/uid/$1',
			/*自动下载网易云mp3*/
			'^music\/(\d+)$'=>'Index/Netease/index/songId/$1',
			/**系统参数**/
			'^start$'=>'Client/Server/startHttp',
			'^log$'=>'Client/Server/startLog',
		);		
	}
}