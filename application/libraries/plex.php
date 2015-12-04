<?php


class Plex {

	private $url;
	private $category;
	private $body;
	private $query;

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->url = commonclass::getConfig("home.home_endpoint");
	}





	public function sendRequest(){


		$this->CI->load->library("curl");
		$this->CI->curl->curl_url($this->CI->url);
		$this->CI->curl->headers(false);
		$this->CI->curl->postfields(http_build_query($this->CI->body));
		$this->CI->curl->curl_post(true);
		$response = $this->CI->curl->curlexec();
		$this->CI->logger->info("response: ".var_export($response, true));
		$this->CI->curl->closeCurl();




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
		$this->CI->config->load("plex");
		$methods = $this->CI->config->item("methods");
		if(array_key_exists($control, $methods))
			$this->CI->url = $this->CI->url.$methods[$control];
		
	}

	public function setQuery($query){
		if(is_string($query))
			$this->CI->query = $query;

	}

}
