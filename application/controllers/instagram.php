<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instagram extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
		
	public function index()
	{
		/*
		$curl_session = curl_init();

		// Set the URL of api call
		curl_setopt($curl_session, CURLOPT_URL, "https://api.instagram.com/v1/media/popular?client_id=3d84f02a4d494a11afe4cffdd7a0b3f7");
		
		// Return the curl results to a variable
		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, 1);
		
		// Execute the cURL session
		$contents = curl_exec ($curl_session);
		
		// Close cURL session
		curl_close ($curl_session);
		
		$insta_data = json_decode($contents);
		echo "<pre>";
		print_r($insta_data);
		echo "</pre>";
		*/
		$this->load->library('instagram_api');
		//error_reporting(E_ALL);
		// Get the popular media
		$insta_objarray = $this->instagram_api->getPopularMedia();
		$array = $insta_objarray->data;
		
		//retreieve the first 10 results from array data.
		$data['popular_media'] = array_slice($array, 0, 10);		
		
		$this->load->view('instagram', $data);
	}
}

