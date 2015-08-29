<?php

class Twitter {


	private $consumerkey; 
	private $consumersecret; 

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->consumerkey = "dNHzQr7YKzhEat1g8ekjw";
		$this->CI->consumersecret = "YsooMso14gNVEreDddmNygimlEwGSfJHXtt1mYuWo";
	}


	public function getTimeline(){
		$this->CI->logger->info("getting timeline");
		$request_url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
		$this->CI->load->library("curl");

		$this->getToken();

		// $this->CI->curl->curl_url($request_url);

		// $postdata = array("Authorization: OAuth oauth_consumer_key=".$this->CI->consumerkey,


	}


	private function getToken(){
		$bearer_credentials = base64_encode($this->CI->consumerkey.":".$this->CI->consumersecret);
		// $this->CI->logger->info("bearer credentials: ".$bearer_credentials);

		$url = "https://api.twitter.com/oauth2/token";

		// $headerdata = array("Authorization: Basic ".


	}


}
