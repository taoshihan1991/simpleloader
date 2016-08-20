<?php
namespace Log2;

class Log{
	const SHOW=true;
	const WRITE=false;
	const FILE="error.log";
	public function __construct(){}
	public static function i($mes,$tag=""){
		$mes="[info] ".$mes;
		self::logTime($mes);
	}
	public static function w($mes,$tag=""){
		$mes="[warn] ".$mes;
		self::logTime($mes);
	}
	public static function e($mes,$tag=""){
		$mes="[error] ".$mes;
		self::logTime($mes);
	}
	public static function logTime($mes){
		list($micseconds,$seconds)=explode(" ",microtime());
		$micseconds=round($micseconds*1000);
		$micseconds=strlen($micseconds)==1 ? '0'.$micseconds : $micseconds;
		$break="\r\n";
		if(php_sapi_name()!="cli"){
				$break="<br/>";
		}
		$mes="[".date("Y-m-d H:i:s",$seconds).":{$micseconds}]".$mes;
		if(self::SHOW){
			$message=$mes.$break;
			echo $message;
		}
		
		if(self::WRITE){
			$mes.="\r\n";
			$handle=fopen(self::FILE, "a");
			fwrite($handle, $mes);
			fclose($handle);
		}
	}
	public static function read($num=1){
		if(!file_exists(self::FILE)){
			return;
		}
		$fp = fopen(self::FILE,"r");
	    $pos = -2;  
	    $eof = "";  
	    $head = false;
	    $lines = array();  
	    while($num>0){  
	        while($eof != "\n"){  
	            if(fseek($fp, $pos, SEEK_END)==0){
	                $eof = fgetc($fp);  
	                $pos--;  
	            }else{                              
	                fseek($fp,0,SEEK_SET);  
	                $head = true;   
	                break;  
	            }  
	              
	        }  
	        array_unshift($lines,fgets($fp));  
	        if($head){ break; }
	        $eof = "";  
	        $num--;  
	    }  
	    fclose($fp);  
	    return array_reverse($lines);
	}
}