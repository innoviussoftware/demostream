<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
    $this->session->sess_destroy();
        $this->session->unset_userdata('login_userdata');
        unset($_SESSION);
        
        $log = 0;
        $this->session->set_userdata('invalid', $log);
        redirect(base_url());
    }

}
