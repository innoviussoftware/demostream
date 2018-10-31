<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Donation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function view_donation() {
            
            $user = $this->session->userdata('login_userdata');
            $UserID = $user['UserID'];

          $url = MY_DONATION . "?UserId=" . $UserID . "&Count=5&PageNum=1";
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data = json_decode(curl_exec($data), true);
            $return = curl_errno($data); //returns 0 if no errors occured
            curl_close($data);

            //echo '<pre>';print_r($response_data);exit;
            $donationdetails['donationdetails'] = $response_data['donationdetails'];


            
            $this->load->view('admin/includes/header');
            $this->load->view('admin/includes/top_header');
            $this->load->view('admin/includes/sidebar');
            //$this->load->view('admin/includes/top-menu');
            $this->load->view('admin/pages/view_donation',$donationdetails);
            $this->load->view('admin/includes/footer');
    }

}

?>
