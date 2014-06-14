<?php

class Portfolio extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        $this->load->model('portfoliomodel');
    }
 
 
    public function index(){
        $data['result'] = $this->portfoliomodel->alldata();
 
        $this->load->view('portfolio', $data);
    }
 
}
