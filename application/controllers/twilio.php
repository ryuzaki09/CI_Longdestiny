<?php


class Twilio extends CI_Controller {
	
	private $home_url;
	const MY_NUMBER = "+447500110989";
	const MY_AGENT = "Nexus 5X";

	public function __construct(){
		parent::__construct();
		$this->load->library('twiliosms');

	}

	public function index($require=false)
	{
		if($this->checkVerifiedUser($require)){
			$this->logger->info("sending sms");
				//TESTED and Working
				// $from = "+447492888257";
				// $to = '+447500110989';
				// $message = 'This is a test...';
				// $response = $this->twiliosms->sms($from, $to, $message);
				// if($response->IsError)
				// 	echo 'Error: ' . $response->ErrorMessage;
				// else
				// 	echo 'Sent message to ' . $to;
				// exit;
		} 

		echo "Go away!";
	}

	public function callback($require){
		$this->logger->info("callback called!");


	}

	public function reply($require){
		$this->logger->info("reply called!");
		//check the request
		if($this->checkRequest()){
			$from = $_POST['To'];
			$to = self::MY_NUMBER;

			if(!$this->checkAction()){
				$message = "Message from ".$_POST['From'].": ".$_POST['Body'];
				$response = $this->twiliosms->sms($from, $to, $message);
				if($response->IsError)
					$this->logger->info('Error: ' . $response->ErrorMessage);
				else
					$this->logger->info('Sent message to ' . $to);
			}
			exit;
		}

	}

	// public function report(Exception $e)
	// {

	// 	$this->_notifyThroughSms($e);
	// 	return parent::report($e);

	// }

	// private function _notifyThroughSms($e)
	// {
	// 	foreach($this->_notificationRecipients() AS $recipient):
	// 		$this->_sendSms(
	// 			$recipient->phone_number,
	// 			'[This is a test] It appears the server'.
	// 			' is having issues. Exception: '.$e->getMessage().
	// 			' Go to http://newrelic.com for more details.'
	// 			);
	// 	endforeach;

	// }

	// private function _sendSms($to, $message)
	// {
	// 	$accountSid = env('TWILIO_ACCOUNT_SID');
	// 	$token		= env('TWILIO_AUTH_TOKEN');
	// 	$twilioNo	= env('TWILIO_NUMBER');

	// 	$twilioService = new Services_Twilio($accountSid, $token);

	// 	try {
	// 		$twilioService->account->messages->create(
	// 			[
	// 				'From' => $twilioNo,
	// 				'To' => $to,
	// 				'Body' => $message
	// 			]
	// 		);
	// 		$this->logger->info("Message sent to: ".$to);

	// 	} catch(Services_Twilio_RestException $e) {
	// 		$this->logger->error("Could not send sms notification".
	// 							" Twilio replied with: ".$e
	// 							);

	// 	}


	// }


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

	// private function checkAction()
	public function checkAction()
	{
		// $body = explode(" ", $this->input->post("body", true));
		$body = "Plex music play song";
		// $body = explode(" ", $body);
		//sample DATA
		$body = array("plex", "music", "play", "song");
		if(!$this->checkLibraryAction($body[0]))
			return false;
		
		$this->processAction($body);
	
	}


	private function processAction($body){

		if(strtolower($body[0]) == "plex"){
			$this->config->load("plex");
			$this->load->library("plex");
			$category = $this->config->item("category");

			if(!in_array($body[1], $category))
				return false;
			
			$control = strtolower($body[2]);
			$this->plex->setControl($control);
			if($control == "search")
				$this->plex->setQuery($body[3]);
			echo "im here";	

		}


	}

	private function checkLibraryAction($action){

		$all_actions = array("plex", "torrent");
		if(in_array($action, $all_actions))
			return true;
		
		return false;

	}

}
