<?php
namespace Controller\User;

class User{
	public function getUserById(){
		return "userinfo id {$_GET['id']}";
	}
	public function getUserList(){
		return "userlist";
	}
	public function getUserArticle(){
		return "user id {$_GET['uid']} article";
	}
}