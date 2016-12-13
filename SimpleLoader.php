<?php
class SimpleLoader{
	const CONTROL_PACKAGE="\\Controller";
	const WRITE_LOG=false;
	public static function getRules(){
		//只是个例子
		return array(
			'^login$'=>'Index/Auth/login',
			'^domains$'=>'Index/Index/index',
			'^domain\/mail\/(\d+)$'=>'Index/Index/getuserByDomain/id/$1',
			'^domain\/add$'=>'Index/Index/addDomain',
			'^domain\/edit\/(\d+)$'=>'Index/Index/editDomain/id/$1',
			'^domain\/del\/(\d+)$'=>'Index/Index/delDomain/id/$1',
			'^user\/add\/(\d+)$'=>'Index/Index/addUser/domainId/$1',
			'^user\/del\/(\d+)$'=>'Index/Index/delUser/id/$1',
			'^user\/edit\/(\d+)$'=>'Index/Index/editUser/id/$1',
			'^group\/(\d+)$'=>'Index/Index/getGroupByDomain/id/$1',
			'^group\/edit\/([\w\W]+)$'=>'Index/Index/editGroup/source/$1',
		);		
	}
	public static function run($rules=array()){
		self::register();
		self::commandLine();
		self::router($rules);
		$html=self::pathInfo();
		self::output($html);
	}
	//自动加载
	public static function loadClass($class){
		$class=str_replace('\\', '/', $class);
		$dir=str_replace('\\', '/', __DIR__);
		$class=$dir."/".$class.".php";
		if(!file_exists($class)){
		}
		require_once $class;		
	}
	//命令行模式
	public static function commandLine(){
		if(php_sapi_name()=="cli"){
			$_SERVER['PATH_INFO']="";
			foreach ($_SERVER['argv'] as $k=>$v) {
				if($k==0) continue;
				$_SERVER['PATH_INFO'].="/".$v;
			}
		}
	}
	//路由模式
	public static function router($rules=array()){
		$ruleFile=self::getRules();
		$rules=array_merge($rules,$ruleFile);
		if(isset($_GET['s'])&&!isset($_SERVER['PATH_INFO'])){
			$_SERVER['PATH_INFO']=$_GET['s'];
		}
		if(isset($_SERVER['PATH_INFO']) && !empty($rules)){
			$pathInfo=ltrim($_SERVER['PATH_INFO'],"/");
			foreach ($rules as $k=>$v) {
				$reg="/".$k."/i";
				if(preg_match($reg,$pathInfo)){
					$res=preg_replace($reg,$v,$pathInfo);
					$_SERVER['PATH_INFO']='/'.$res;
				}
			}
		}
	}
	//pathinfo处理
	public static function pathInfo(){

		if(isset($_SERVER['PATH_INFO'])){
			$pathinfo=array_filter(explode("/", $_SERVER['PATH_INFO']));
			for($i=1;$i<=count($pathinfo);$i++){
				$key=isset($pathinfo[$i]) ? $pathinfo[$i] : '';
				$value=isset($pathinfo[$i+1]) ? $pathinfo[$i+1] :"";
				switch ($i) {
					case 1:
						$_GET['m']=ucfirst($key);
						break;
					case 2:
						$_GET['c']=ucfirst($key);
						break;
					case 3:
						$_GET['a']=$key;
						break;
					default:
						if($i>3){
							if($i%2==0){
								$_GET[$key]=$value;
							}
						}
						break;
				}
			}
		}
		$_GET['m']=!empty($_GET['m']) ? ucfirst($_GET['m']) : 'Index';
		$_GET['c']=!empty($_GET['c']) ? ucfirst($_GET['c']) : 'Index';
		$_GET['a']=!empty($_GET['a']) ? $_GET['a'] : 'index';
		$class=self::CONTROL_PACKAGE."\\{$_GET['m']}\\{$_GET['c']}";
		$controller=new $class;
		if(method_exists($controller, $_GET['a'])){
			$controller=new $class;
			return $controller->$_GET['a']();
		}else{
			header("HTTP/1.1 404 Not Found");
			exit("404");
		}
	}
	//输出
	public static function output($html=""){
		if(php_sapi_name()=="cli"){
			return $html;
		}else{
			echo $html;
		}
	}
	//致命错误回调
	public static function shutdownCallback(){
		$e=error_get_last();
		if(!$e) return;
		if(php_sapi_name()=="cli"){
			$level='Fatal Error ';
		}else{
			$level='<font color="red">Fatal Error</font> ';
		}
		self::myErrorHandler($e['type'],$level.$e['message'],$e['file'],$e['line']);
	}
	//错误处理
	public static function myErrorHandler($errno,$errstr,$errfile,$errline){
		list($micseconds,$seconds)=explode(" ",microtime());
		$micseconds=round($micseconds*1000);
		$micseconds=strlen($micseconds)==1 ? '0'.$micseconds : $micseconds;
		if(php_sapi_name()=="cli"){
			$mes="[".date("Y-m-d H:i:s",$seconds).":{$micseconds}] ".$errfile." ".$errline." line ".$errstr."\r\n\r\n";
		}else{
			$mes="<b>[".date("Y-m-d H:i:s",$seconds).":{$micseconds}] ".$errfile." ".$errline." line ".$errstr."</b><br/><br/>";
		}
		echo $mes;	
		if(self::WRITE_LOG){
			$mes="[".date("Y-m-d H:i:s",$seconds).":{$micseconds}] ".$errfile." ".$errline." line ".$errstr."\r\n";
			$handle=fopen("error.log", "a");
			fwrite($handle, $mes);
			fclose($handle);
		}	
	}
	//注册
	public static function register(){
		error_reporting(0);
		set_error_handler(function($errno,$errstr,$errfile,$errline){
			SimpleLoader::myErrorHandler($errno,$errstr,$errfile,$errline);
		});
		register_shutdown_function(function(){
			SimpleLoader::shutdownCallback();
		});
		spl_autoload_register("self::loadClass");
	}
}