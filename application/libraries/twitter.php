<?php

class Twitter {


	private $consumerkey; 
	private $consumersecret; 

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->consumerkey = "dNHzQr7YKzhEat1g8ekjw";
		$this->CI->consumersecret = "YsooMso14gNVEreDddmNygimlEwGSfJHXtt1mYuWo";
		$this->CI->load->library("curl");
	}


	public function getTimeline(){
		$request_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=ryuzaki09&count=5";
		// $request_url = "https://api.twitter.com/1.1/statuses/mentions_timeline.json?count=5";
		$access_token = $this->getToken();
		$this->CI->logger->info("access token: ".$access_token);
		// $request_url = "https://api.twitter.com/1.1/statuses/home_timeline.json?count=5";

		$headerdata = array("Authorization: Bearer ".$access_token, "Content-Type: application/x-www-form-urlencoded;charset=UTF-8");

		// $postdata = array("count" => 5);

		$this->CI->logger->info("getting timeline");
		$this->CI->curl->curl_url($request_url);
		$this->CI->curl->curl_post(false);
		$this->CI->curl->http_header($headerdata);
		// $this->CI->curl->postfields($postdata);
		$this->CI->curl->returnTransfer(true);
		$result = $this->CI->curl->curlexec();
		$result_decode = json_decode($result);
		echo "<pre>";
		print_r($result_decode);
		echo "</pre>";
		
		$this->CI->logger->info("timeline response: ".var_export($result, true));

		return $result_decode;


	}


	private function getToken(){
		$this->CI->logger->info("Get access token");
		$bearer_credentials = base64_encode(urlencode($this->CI->consumerkey).":".urlencode($this->CI->consumersecret));

		$url = "https://api.twitter.com/oauth2/token";

		$headerdata = array("Authorization: Basic ".$bearer_credentials, "Content-Type: application/x-www-form-urlencoded;charset=UTF-8");

		$postbody = "grant_type=client_credentials";

		$this->CI->curl->curl_url($url);
		$this->CI->curl->curl_post(true);
		$this->CI->curl->http_header($headerdata);
		$this->CI->curl->returnTransfer(true);
		$this->CI->curl->postfields($postbody);

		$result = $this->CI->curl->curlexec();
		$result_decode = json_decode($result);

		$this->CI->logger->info("response: ".var_Export($result, true));
		// $this->CI->logger->info("error: ".var_Export($result_decode->{'errors'}, true));

		if($result_decode->{'access_token'}){
			$this->CI->logger->info("Token retrieved successfully");
			// $this->CI->logger->info("Token: ".$result_decode->{'access_token'});
			return $result_decode->{'access_token'};
		}

		if($result_decode->{'errors'}){
			$this->CI->logger->info("response: ".var_Export($result, true));
			$this->CI->logger->info("Cannot get Token");
			return false;
		}

	}


}
