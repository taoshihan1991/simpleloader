<?php
namespace lib;
class es{
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
		$client = new \GuzzleHttp\Client();
		$condition=array();
		$condition['json']['query']['multi_match']['query']="PHP7";
		$condition['json']['query']['multi_match']['type']="most_fields";
		$condition['json']['query']['multi_match']['fields']=['content','title','link'];
		$condition['json']['highlight']['fields']['content']=new \stdclass();
		$condition['json']['highlight']['fields']['title']=new \stdclass();
		$res = $client->request('POST', 'http://127.0.0.1:9200/sinamail/laruence/_search',$condition);

		$json=$res->getBody();
		$arr=json_decode($json,true);
		return $arr;
	}
	public function deleteEs(){
		$client = new \GuzzleHttp\Client();
		$condition=array();
		$condition['json']['query']['match_all']=new \Stdclass();
		$res = $client->request('POST', 'http://127.0.0.1:9200/sinamail/laruence/_delete_by_query',$condition);

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



}

