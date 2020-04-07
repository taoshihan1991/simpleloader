<?php
namespace controller\cmd;

use QL\QueryList;
class pig{
    public function run(){
       //采集某页面所有的图片
       $data = QueryList::get('http://cms.querylist.cc/bizhi/453.html')->find('img')->attrs('src');
       //打印结果
       print_r($data->all());
        echo 222;
    }
}
