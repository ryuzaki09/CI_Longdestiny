<?php


class Plex {

	private $url;
	private $category;
	private $body;
	private $query;
	private $control;

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->url = commonclass::getConfig("home.home_endpoint");
		$this->CI->body = NULL;
	}



	public function sendRequest($url){
		// $body = json_encode($this->CI->body);
		$header = array("Content-type: application/json",
						"Client-ID: ryuzakiluong");
						// "Content-length: ".strlen($body)
					//	);
		
		$this->CI->logger->info("url: ".$this->CI->url.$url);
		// $this->CI->logger->info("body: ".var_Export($this->CI->body, true));

		$this->CI->load->library("curl");
		$this->CI->curl->curl_url($this->CI->url.$url);
		$this->CI->curl->returnTransfer(true);
		$this->CI->curl->http_header($header);

		error_log("body: ".var_Export($this->CI->body, true));
		if(!is_null($this->CI->body)){
			$this->CI->curl->postfields($this->CI->body);
		}

		$this->CI->curl->curl_post(true);
		$response = $this->CI->curl->curlexec();
		$this->CI->logger->info("response: ".var_export($response, true));
		$this->CI->curl->closeCurl();

		return $response;

	}


	public function setCategory($category){

		if(is_string($category))
			$this->CI->category = $category;

	} 

	public function setBody($body){
		if(is_array($body))
			$this->CI->body = $body;

	}
	
	public function setControl($control){
		if(is_string($control))
			$this->CI->control = $control;
		
	}

	public function setQuery($query){
		if(is_string($query))
			$this->CI->query = $query;

	}

}
