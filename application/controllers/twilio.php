<?php


class Twilio extends CI_Controller {


	public function __construct(){
		parent::__construct();

	}

	public function index()
	{
		$this->load->library('twiliosms');
		$from = "+447492888257";
		$to = '+447500110989';
		$message = 'This is a test...';
		$response = $this->twiliosms->sms($from, $to, $message);
		if($response->IsError)
			echo 'Error: ' . $response->ErrorMessage;
		else
			echo 'Sent message to ' . $to;
	}

	public function callback(){



	}

	public function report(Exception $e)
	{

		$this->_notifyThroughSms($e);
		return parent::report($e);

	}

	private function _notifyThroughSms($e)
	{
		foreach($this->_notificationRecipients() AS $recipient):
			$this->_sendSms(
				$recipient->phone_number,
				'[This is a test] It appears the server'.
				' is having issues. Exception: '.$e->getMessage().
				' Go to http://newrelic.com for more details.'
				);
		endforeach;

	}

	private function _sendSms($to, $message)
	{
		$accountSid = env('TWILIO_ACCOUNT_SID');
		$token		= env('TWILIO_AUTH_TOKEN');
		$twilioNo	= env('TWILIO_NUMBER');

		$twilioService = new Services_Twilio($accountSid, $token);

		try {
			$twilioService->account->messages->create(
				[
					'From' => $twilioNo,
					'To' => $to,
					'Body' => $message
				]
			);
			$this->logger->info("Message sent to: ".$to);

		} catch(Services_Twilio_RestException $e) {
			$this->logger->error("Could not send sms notification".
								" Twilio replied with: ".$e
								);

		}


	}


}
