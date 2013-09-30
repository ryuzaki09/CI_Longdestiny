<?php

class Logger {

	public function __construct(){
		$this->CI =& get_instance();
	}


	public function info($info){
		$file = "/var/log/dev/longdestiny/longdestiny.log";
		/*if(!file_exists($file)){
			$log = fopen($file, "x");	
		} else {
			$log = fopen($file, "w");	
		}*/
		$date = date('Y/m/d H:i:s');
		$fp = fopen($file, "a");
		fwrite($fp, "[".$date."][INFO] - ".$info."\n");
		fclose($fp);
	
	}




}
