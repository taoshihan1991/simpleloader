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