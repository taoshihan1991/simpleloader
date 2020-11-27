<?php
namespace controller\cmd;

use QL\QueryList;
class pig{
	public function run(){
		$this->getArticle();
	}
	public function getArticle(){
		$app=\app::getInstance();
		$pdo=$app->make("pdo");

		foreach($this->getList() as $k=>$list){
			foreach($list as $row){
				$ql = QueryList::get($row['link']);
				$row['content'] = $ql->find('.post-content')->html();
				$sql="insert into laruence (title,link,content)values('{$row['title']}','{$row['link']}',:content)";
				try{

					$r=$pdo->execute($sql,array(":content"=>$row['content']));
					var_dump($row['title'],$row['link'],$r);
				}catch(\Exception $e){
					var_dump($row['title'],$row['link'],$e->getMessage());
				}
			}
		}
	}
	public function getList(){
		$range="#loop-container .post-container";
		$rule=array();
		$rule['title'] = ['.post-title>a','text'];
		$rule['link'] = ['.post-title>a','href'];
		for($i=1;$i<29;$i++){
			$url="https://www.laruence.com/page/{$i}";
			$ql = QueryList::get($url);
			yield $ql->range($range)->rules($rule)->queryData();
		}

	}
	public function addEs(){
		$app=\app::getInstance();
		$pdo=$app->make("pdo");

		$all=$pdo->fetchAll("select * from laruence");
		$client = new \GuzzleHttp\Client();

		foreach($all as $a){
			$data=[];
			$data['json']['title']=$a['title'];
			$data['json']['content']=strip_tags($a['content']);
			$data['json']['link']=$a['link'];
			$res = $client->request('POST',"http://127.0.0.1:9200/sinamail/laruence",$data);
			$json=$res->getBody()->getContents();
			var_dump($a["title"]);
		}

	}
	public function search(){
		$q=$_SERVER['argv'];
		$es=new \lib\es();
		$list=$es->search($q[4]);
		print_r($list['hits']['hits']['highlight']);
	}
	public function deleteEs(){
		$client = new \GuzzleHttp\Client();
		$condition=array();
		//$condition['json']['query']['match_all']=new \Stdclass();
		$res = $client->request('DELETE', 'http://127.0.0.1:9200/sinamail/laruence',$condition);

		$json=$res->getBody();
		$arr=json_decode($json,true);
		print_r($arr);
	}
	public function createEs(){
		$client = new \GuzzleHttp\Client();
		$condition=array();
		$condition['json']['laruence']['properties']['title']=array("type"=>'string');
		$condition['json']['laruence']['properties']['link']=array("type"=>'string');
		$condition['json']['laruence']['properties']['content']=array("type"=>'string');
		$res = $client->request('PUT', 'http://127.0.0.1:9200/sinamail/laruence/_mapping',$condition);

		$json=$res->getBody();
		$arr=json_decode($json,true);
		print_r($arr);
	}
	public function testGuzz(){
		$client = new \GuzzleHttp\Client();
		// 发送一个异步请求
		$request = new \GuzzleHttp\Psr7\Request('GET', 'http://www.sopans.com');
		$request2 = new \GuzzleHttp\Psr7\Request('GET', 'http://www.sopans.com/laruence');
		$request3 = new \GuzzleHttp\Psr7\Request('GET', 'http://www.sopans.com/about');
		$promise = $client->sendAsync($request)->then(function ($response) {
				echo 111;
				});
		$promise = $client->sendAsync($request2)->then(function ($response)use($client,$request3) {
				$client->sendAsync($request3)->then(function ($res){
						echo 444;
						});
				echo 222;
				});
		echo 333;
		$promise->wait();
	}
	public function testHot(){
		$es=new \lib\es();
		$es->hot();
	}
	public function addMo(){
	}
}
