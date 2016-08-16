<?php
namespace Controller\User;

class User{
	public function getUserById(){
		return "用户信息id {$_GET['id']} 的信息";
	}
	public function getUserList(){
		return "用户列表";
	}
	public function getUserArticle(){
		return "用户id {$_GET['uid']} 的文章列表";
	}
}