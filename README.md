## 简介

SimpleLoader 是一个免费开源、简单的面向对象PHP模块加载器 ，目标是提供最轻便的路由加载处理功能，只有一个文件包含全部功能代码，没有框架的复杂，非常适合小型测试代码演示使用。

## 全面的路由处理特性支持

最新的SimpleLoader为应用模块化和API接口开发提供了强有力的支持，这些支持包括：

*  友好的RESTful风格路由映射
*  PathInfo模式加载控制器
*  普通传参形式模块加载
*  命令行传参支持

## 模块化的开发理念

基于psr规范，充分发挥PHP命名空间特性，解析URL自动加载到指定控制器。符合psr规范的第三方模块，只需use PackageName\ClassName，即可自动加载第三方类路径，直接new使用，再也不用各种require，使您的应用更加规范可读，灵活多变。

## 如何使用

规定`Controller`目录是控制器目录，新建文件`Controller/User.php`，此时就能使用pathinfo模式来访问这个控制器，`http://域名/index.php/user/user/getUserList`
```php
<?php
namespace Controller\User;

class User{
	public function getUserById(){
		echo "用户信息id {$_GET['id']} 的信息";
	}
	public function getUserList(){
		echo "用户列表";
	}
	public function getUserArticle(){
		echo "用户id {$_GET['uid']} 的文章列表";
	}
}
```


`index.php`就是程序的入口文件，在入口文件中定义路由规则，路由规则是正则来匹配的，引入SimpleLoader，此时可以使用自定义路由来访问控制器`http://域名/index.php/user/123456/article`
```php
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
```


命令行下运行同样支持路由映射，参数以空格隔开，例如如下方式`E:\phpServer\htdocs\simpleloader>php index.php client user`

增加的`.htaccess`文件可以实现访问URL时去掉`index.php`，例如`http://域名/user/123456/article`

## 下载网易云歌单歌曲
命令行下`php index.php music 424038303` 数字为歌单id

## 商业友好的开源协议

SimpleLoader遵循Apache2开源协议发布。Apache Licence是著名的非盈利开源组织Apache采用的协议。该协议和BSD类似，鼓励代码共享和尊重原作者的著作权，同样允许代码修改，再作为开源或商业软件发布。