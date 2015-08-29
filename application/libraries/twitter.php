<?php

class Twitter {



	public function __construct(){
		$this->CI =& get_instance();
	}


	public function getTimeline(){
		$request_url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
		$this->CI->load->library("curl");

		$this->CI->curl->curl_url($request_url);

		$postdata = array("Authorization: OAuth oauth_consumer_key=".$this->CI->consumerkey,


	}


}
