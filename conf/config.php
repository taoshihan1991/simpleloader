<?php
namespace conf;
class config{
    private $data=array(
        'db'=>array(
            'class'=>'lib\pdo',
            'dsn'=>'mysql:dbname=notice;host=127.0.0.1;charset=utf8',
            'username'=>'root',
            'password'=>'TAOshihan1',
            'persistent'=>false,
        ),
    );
    public function __set($name,$value){
        $this->data[$name]=$value;
    }
    public function __get($name){
        if(!isset($this->data[$name])){
            return "";
        }
        return $this->data[$name];
    }
}

