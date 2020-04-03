<?php
class app{
        private static $instance = null;
        private $actionMethod=null;
	private $swoole=null;
        private $router=array();
        private $control="\\controller";
        private $bindings=array();
        private $resource=array();
        private function __construct(){}
        public static function getInstance(){
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
	public function run($rules=array()){
                $this->setActionMethod();
		$this->registerAutoload();
		if(!is_null($this->swoole)){
			$this->swoole->start();
		}else{
			$this->commandLine();
			$this->router($rules);
			$html=$this->pathInfo();
			echo $html;
		}
	}
	public static function callbackSwoole($req,$res){
    		if ($req->server['path_info'] == '/favicon.ico' || $req->server['request_uri'] == '/favicon.ico') {
        		$res->end();
        		return;
    		}
		$app=self::getInstance();
		$uri=str_replace("/index.php","",$req->server['request_uri']);
                if(strpos($uri,"?")!==false){
                    $uri=substr($uri,0,strpos($uri,'?'));
                }
                $uri=trim($uri,'/');
		$app->setActionMethod($uri);
		$app->router();
		$html=$app->pathInfo();
		$res->end($html);
		
	}
	public function setSwoole($swoole){
		$this->swoole=$swoole;
		$this->swoole->on('request',__CLASS__ . "::callbackSwoole");
		return $this;
	}
        private function setActionMethod($newUri=null){
            if($newUri==null && php_sapi_name()!="cli"){
                $uri=str_replace("/index.php","",$_SERVER['REQUEST_URI']);
                if(strpos($uri,"?")!==false){
                    $uri=substr($uri,0,strpos($uri,'?'));
                }
                $uri=trim($uri,'/');
                $this->actionMethod=$uri;
            }else{
                $this->actionMethod=$newUri;
            }
        }
	//自动加载
	public static function loadClass($class){
            $class=str_replace('\\', '/', $class);
            $dir=str_replace('\\', '/', __DIR__);
            $class=$dir."/".$class.".php";
            if(!file_exists($class)){
                $class='lib'.$class;
                if(!class_exists($class)){
                    return false;
                }
            }
            require_once $class;		
	}
	//命令行模式
	private function commandLine(){
		if(php_sapi_name()=="cli"){
			$uri="";
			foreach ($_SERVER['argv'] as $k=>$v) {
                                if($k==0){
                                    continue;
                                }else if($k==1){
                                    $uri=$v;
                                }else{
                                   $uri.="/".$v; 
                                } 
			}
                        $this->setActionMethod($uri);
		}
	}
        public function setRouter($router){
            $this->router=$router;
            return $this;
        }
	//路由模式
	private function router(){
            $rules=$this->router;
            if(!empty($this->actionMethod) && !empty($rules)){
                    foreach ($rules as $k=>$v) {
                            $reg="/{$k}/i";
                            if(preg_match($reg,$this->actionMethod)){
                                    $res=preg_replace($reg,$v,$this->actionMethod);
                                    $this->setActionMethod($res);
                            }
                    }
            }
	}
	//pathinfo处理
	private function pathInfo(){
		if(!empty($this->actionMethod)){
			$pathinfo=array_filter(explode("/", $this->actionMethod));
			for($i=0;$i<=count($pathinfo);$i++){
				$key=isset($pathinfo[$i]) ? $pathinfo[$i] : '';
				$value=isset($pathinfo[$i+1]) ? $pathinfo[$i+1] :"";
				switch ($i) {
					case 0:
						$_GET['m']= strtolower($key);
						break;
					case 1:
						$_GET['c']=strtolower($key);
						break;
					case 2:
						$_GET['a']=$key;
						break;
					default:
						if($i>2){
							if($i%2==1){
								$_GET[$key]=$value;
							}
						}
						break;
				}
			}
		}
		$_GET['m']=!empty($_GET['m']) ? strtolower($_GET['m']) : 'index';
		$_GET['c']=!empty($_GET['c']) ? strtolower($_GET['c']) : 'index';
		$_GET['a']=!empty($_GET['a']) ? $_GET['a'] : 'index';
		$class=$this->control."\\{$_GET['m']}\\{$_GET['c']}";
		if(!class_exists($class)){
			header("HTTP/1.1 404 Not Found");
			return "{$class} class not exists";
		}
		$controller=new $class;
		if(method_exists($controller, $_GET['a'])){
			$controller=new $class;
                        $method=$_GET['a'];
			return $controller->$method();
		}else{
			header("HTTP/1.1 404 Not Found");
			return "{$_GET['a']} method not exists";
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
	//注册
	private function registerAutoload(){
		spl_autoload_register("self::loadClass");
	}
        //注册类
        public function bind($id,$func){
            $this->bindings[$id]=$func;
        }
        //创建对象
        public function make($id,$parameters=array()){
            if(!isset($this->resource[$id])){
                $this->resource[$id]=call_user_func_array($this->bindings[$id],$parameters);
            }
            return $this->resource[$id];
        }
}
