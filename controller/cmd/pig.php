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
		var_dump($pdo);

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
}
