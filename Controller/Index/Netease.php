<?php
namespace Controller\Index;

use Log2\Log;
class Netease{
	public function index(){
		// 歌单的id
		$songId=isset($_GET['songId']) ? $_GET['songId'] : '';
		$neteast=$this->https_request("http://music.163.com/api/playlist/detail?id={$songId}");
		$neteastJson=json_decode($neteast,true);
		if($neteastJson['code']==200){
			$songs=$neteastJson['result']['tracks'];
			$result="";
			foreach($songs as $song){
				$temp=array();
				$temp['title']=$song['album']['name'];
				$temp['url']=$song['mp3Url'];
				$this->downLoad($temp['url'],$temp['title'].".mp3");
				$result.=$temp['title']."===".$temp['url']."\r\n";
			}
			file_put_contents("music.txt", $result);
			Log::i("do ok!");
		}
	}
	public function https_request($url,$data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
	public function downLoad($url,$name){
		$fileSize = @filesize($url);  
		header ( "Pragma: public" );  
		header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );  
		header ( "Cache-Control: private", false );  
		header ( "Content-Transfer-Encoding: binary" );  
		header ( "Content-Type:audio/mpeg MP3");  
		header ( "Content-Length: " . $fileSize);  
		header ( "Content-Disposition: attachment; filename=".$name);
		$file = file_get_contents($url);
		$fp = fopen(iconv("utf-8","gb2312",$name), 'w');  
		fwrite($fp, $file);  
		fclose($fp);  
	}
}