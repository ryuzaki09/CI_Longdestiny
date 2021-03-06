<?php

class Twitter {

	const TWITTER_API_HOST = "https://api.twitter.com";

	private $consumerkey; 
	private $consumersecret; 

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->consumerkey = commonclass::getConfig("longdestiny.twitter_consumerkey");
		$this->CI->consumersecret = commonclass::getConfig("longdestiny.twitter_consumersecret");
		$this->CI->load->library("curl");
	}


	public function getTimeline(){
		$request_url = self::TWITTER_API_HOST."/1.1/statuses/user_timeline.json?screen_name=ryuzaki09&count=10";
		$access_token = $this->getToken();
		// $this->CI->logger->info("access token: ".$access_token);

		$headerdata = array("Authorization: Bearer ".$access_token, 
							"Content-Type: application/x-www-form-urlencoded;charset=UTF-8");

		// $postdata = array("count" => 5);

		$this->CI->logger->info("getting timeline");
		$this->CI->curl->curl_url($request_url);
		$this->CI->curl->curl_post(false);
		$this->CI->curl->http_header($headerdata);
		// $this->CI->curl->postfields($postdata);
		$this->CI->curl->returnTransfer(true);
		$result = $this->CI->curl->curlexec();
		$result_decode = json_decode($result);
		// echo "<pre>";
		// print_r($result_decode);
		// echo "</pre>";
		
		$this->CI->logger->info("timeline response: ".var_export($result_decode, true));

		return $result_decode;


	}


	private function getToken(){
		$this->CI->logger->info("Get access token");
		$bearer_credentials = base64_encode(urlencode($this->CI->consumerkey).":".urlencode($this->CI->consumersecret));

		$url = self::TWITTER_API_HOST."/oauth2/token";

		$headerdata = array("Authorization: Basic ".$bearer_credentials, "Content-Type: application/x-www-form-urlencoded;charset=UTF-8");

		$postbody = array("grant_type" => "client_credentials");

		$this->CI->curl->curl_url($url);
		$this->CI->curl->curl_post(true);
		$this->CI->curl->http_header($headerdata);
		$this->CI->curl->returnTransfer(true);
		$this->CI->curl->postfields($postbody);

		$result = $this->CI->curl->curlexec();
		$result_decode = json_decode($result);

		$this->CI->logger->info("token response: ".var_Export($result, true));

		if(isset($result_decode->{'access_token'})){
			$this->CI->logger->info("Token retrieved successfully");
			return $result_decode->{'access_token'};
		}

		if(isset($result_decode->{'errors'})){
			$this->CI->logger->info("response: ".var_Export($result, true));
			$this->CI->logger->info("Cannot get Token");
			return false;
		}

	}


}
