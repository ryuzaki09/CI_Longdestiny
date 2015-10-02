<?php

class Frontpage extends CI_Controller {

	const MEM_CACHE_TIMEOUT = 600;
    
    public function __construct(){
        parent::__construct();
        $this->load->library('loadpage');
    }
  
    
    public function index(){
		$this->logger->info("loading frontpage");
        $this->load->model('fpmodel');
		$this->load->library("twitter");
		$this->load->driver('cache');

		if(!$this->cache->memcached->is_supported())
			$this->logger->error("Memcached is not supported");
        
		$twitter = $this->cache->memcached->get("twitter_tweets");
		if(!$twitter){
			$twitter = $this->twitter->getTimeline();
			//save to cache
			$this->logger->info("saving twitter tweets to memcache");
			$this->cache->memcached->save("twitter_tweets", $twitter, self::MEM_CACHE_TIMEOUT);
		} else {
			$this->logger->info("Using twitter tweets memcached");
		}

		$data['twitter'] = $twitter;
        $data['data'] = $this->fpmodel->all_frontpage_data();
        $data['list_photos'] = $this->fpmodel->all_fpphotos_data();
        
        $data['css'][] = $this->loadpage->set('css', 'css/style.css');        
        $data['css'][] = $this->loadpage->set('css', 'css/twitter.css');
        
        $data['title'] = "SINLUONG";
        $data['contact_page'] = $this->load->view('contact', '', true);
        
        $this->loadpage->loadpage('frontpage', $data);
        
    }
    
    
    public function contact_msg(){
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
			$this->logger->info("contact started");
			$this->load->helper('email');
			$from = $this->input->post('name', true);
			$email = $this->input->post('email', true);
			$website = $this->input->post('website', true);
			$msg = $this->input->post('msg', true);
			$copy = $this->input->post('copy');
			
			if(valid_email($email)){
				/*$this->load->library('email');                                
				$this->email->from($email, $from);
				$this->email->to('arlong2k8@googlemail.com'); 
				if($copy == "mailcopy"){
					$this->email->cc($email); 
				}

				$this->email->subject('Email from '.$from.' via Longdestiny.com');
				if($website != ""){                
					$this->email->message("<html><head></head><body><h2>Message: ".$msg."</h2></body></html>");                
				} else {
					$this->email->message($msg);	
				}
				
				$this->email->send();            
				echo "true";*/
				
				$to = "arlong2k8@googlemail.com";
				$subject = "Message from ".base_url()." site!";
					
				$body = "Name : " . $from . "<br/>
						 Email: " . $email . "<br/>
						 Website: " . $website . "<br /><br />
						 Message: " . $msg;
				
				$headers = "From: $email\r\n";
				$headers .= "Content-type: text/html\r\n";
				if ($copy != "") { $to = $to . "," . $email; }
									
				if (mail($to, $subject, $body, $headers)) {
					$this->logger->info("email sent to ".$email);
					echo "true";
				} else {
					$this->logger->info("cannot send email to ".$email);
					echo "Message delivery failed...";
				}	
				
			} else {
				echo "Invalid Email!";
			}
		}
    }
    
    
    
}


?>
