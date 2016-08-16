<?php
namespace Server;

class Socket{
	const PORT=1024;
	public function create(){
		$socket=socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_bind($socket, "127.0.0.1",self::PORT);
		socket_listen($socket,4);
        echo "start http://127.0.0.1:1024\r\n";
		while(true) {
    		$msgsock = socket_accept($socket);
    	 	$buf = socket_read($msgsock,9024);
			if(preg_match("/\/(.*) HTTP\/1\.1/",$buf,$matchs)){
                if($matchs[1]!="favicon.ico"){
                    echo $buf;
                    $_SERVER['PATH_INFO']=$matchs[1] ? $matchs[1] : "Index/Index/index";
                    \SimpleLoader::router();
                    $html=\SimpleLoader::pathInfo();
                }
                socket_write($msgsock,$html);
            }else{
                socket_write($msgsock,"hello world");
            }
    	 	socket_close($msgsock);
		} 
		socket_close($socket);
	}
}