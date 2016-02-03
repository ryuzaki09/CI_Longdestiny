<?php


class Twilio extends CI_Controller {
	
	private $home_url;
	private $code;
	private $message;

	const MY_NUMBER = "+447500110989";
	const MY_AGENT = "Nexus 5X";

	public function __construct(){
		parent::__construct();
		$this->load->library('twiliosms');
		$this->config->load("plex");
		$this->load->library("plex");

	}

	public function index($require=false)
	{
		if($this->checkVerifiedUser($require)){
			$this->logger->info("sending sms");
		} 

		echo "Go away!";
	}

	public function callback($require){
		$this->logger->info("callback called!");


	}

	public function reply($require=false){
		$this->logger->info("reply called!");
		// $this->logger->info("post: ".var_Export($_POST, true));
		//check the request
		if($this->checkRequest()){
			// $from = $_POST['To'];
			// $this->logger->info("post: ".var_Export($_POST, true));
			$body = explode(" ",$_POST['Body']);
			// $this->logger->info("body: ".var_Export($body, true));
			// $body = array("download", "naruto");
			
			$url = $this->getActionUrl($body);
			if(!$url)
				$this->sendSMS();

			$result = $this->processAction($body, $url);
			// $result = NULL;
			if(!$result)
				$this->sendSMS();

			$result = json_decode($result, true);
			$this->logger->info("result: ".var_Export($result, true));
			$this->message = "From Homeserver\n";

			if(isset($result['data'])){
				$this->message .= "Reply back with the number of which movie you want to see.\n";

				foreach($result['data'] AS $data => $value):
					$this->message .= $data.". ".$value['title']."\n";
				endforeach;
			} else {
				$this->message .= $result['message']."\n";
			}

			$this->logger->info("message: ".var_Export($this->message, true));
			$this->sendSMS();

		}

	}


	private function checkVerifiedUser($require)
	{

		if($require == "sendwish"){
			$agent = $_SERVER['HTTP_USER_AGENT'];
			if(strpos($agent, self::MY_AGENT))
				return true;

		}
		return false;

	}

	private function checkRequest(){
		$this->logger->info("checking request");

		if($_SERVER['CONTENT_TYPE'] == 'application/x-www-form-urlencoded' && isset($_POST['MessageSid']) && isset($_POST['ApiVersion']) && $_POST['ApiVersion'] == commonclass::getConfig("longdestiny.twilio_api_version"))
			return true;
		else
			return false;


	}

	private function getActionUrl($body)
	// public function checkAction()
	{
		// $smsbody = "play movies robocop";
		// $body = explode(" ", $smsbody);
		// $word = str_replace("+", " ", $body[2]);
		// print_r($word);

		//sample DATA
		// $body = array("play", "music", "song");
		$this->logger->info("processing action");
		return $this->checkLibraryAction(strtolower($body[0]));
		// $this->logger->info("url: ".var_Export($url, true));
	
	}


	private function processAction($body, $url){
		$this->logger->info("process body: ".var_export($body, true));

		if(strtolower($body[0]) == "play"){
			//check next value
			$category = $this->config->item("category");

			if(!in_array($body[1], $category))
				return false;

		
			$query = str_replace("+", " ", $body[2]);
			
			$postdata = array("control" => $body[0],
								"category" => $body[1],
								"keyword" => $query
							);	
			$this->plex->setBody($postdata);

			// $control = strtolower($body[0]);
			//set control
			// $this->plex->setControl($control);
			//if control is search then set the query
			// if($control == "search")
			// $this->plex->setQuery($body[2]);
			//set category
			
			// $this->plex->setCategory($body[1]);
			$this->logger->info("postdata: ".var_export($postdata, true));
			return $this->plex->sendRequest($url);

		}

		if(strtolower($body[0]) == "download"){
			if (!isset($body[1])){
				$this->code = 502;
				$this->message = "missing query";
				return false;
			}
			$query = str_replace("+", " ", $body[1]);
			$postdata = array("query" => $query);
			if(isset($body[2]) && is_numeric($body[2]))
				$postdata['episode'] = $body[2];

			$this->plex->setBody($postdata);
			$this->logger->info("postdata: ".var_export($postdata, true));
			return $this->plex->sendRequest($url);
		}

		if(strtolower($body[0]) == "hkdrama" || strtolower($body[0]) == "jdrama"){
			// if (!isset($body[1])){
			// 	$this->code = 502;
			// 	$this->message = "missing query";
			// 	return false;
			// }
			$postdata = array("query" => false, "episode" => false);
			if(isset($body[1]))
				$postdata['query'] = str_replace("+", " ", $body[1]);

			if(isset($body[2]) && is_numeric($body[2]))
				$postdata['episode'] = $body[2];

			$this->plex->setBody($postdata);
			$this->logger->info("postdata: ".var_export($postdata, true));
			return $this->plex->sendRequest($url);
		}
	}

	//GET url of Control from config
	private function checkLibraryAction($action){
		$this->logger->info("get action: ".$action);

		$all_actions = $this->config->item("methods");
		// $this->logger->info("all methods: ".var_export($all_actions, true));
		if(array_key_exists($action, $all_actions))
			return $all_actions[$action];
		
		return false;

	}

	public function get($keyword=false){

		if(!$keyword){
			echo "Not allowed";
			exit;
		}

		$configKeywords = $this->config->item("getKeywords");
		// print_R($configKeywords);
		if(in_array($keyword, $configKeywords)){
			// $data = $configKeywords[$keyword];
			$this->plex->setBody(array("keyword" => $keyword));
			$result = $this->plex->sendRequest("plex/__getDetails");
			print_r($result);
			// echo "here";

		} else {

			echo "Not Allowed";
		}


	}
	
	private function sendSMS(){

		if(!$this->message)
			$this->message = "Something went wrong";
		$response = $this->twiliosms->sms(self::MY_NUMBER, self::MY_NUMBER, $this->message);
		if($response->IsError)
			$this->logger->info('Error: ' . $response->ErrorMessage);
		else
			$this->logger->info('Sent message to ' . self::MY_NUMBER);

		exit;

	}

}
