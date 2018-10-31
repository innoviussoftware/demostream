<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function view($page = 'login') {
        if (!file_exists(APPPATH . "views/admin/pages/" . $page . ".php")) {
            show_404();
            exit;
        }
        if ($page == 'login') {
            redirect(base_url('Hauth/users'));
            //$this->load->view('admin/includes/header');
            //$this->load->view('admin/includes/top-menu');
            $this->load->view('admin/pages/' . $page);
            //$this->load->view('admin/includes/footer');
        } else {
            $this->load->view('admin/includes/header');
            //$this->load->view('admin/includes/top-menu');
            $this->load->view('admin/pages/home');
            //$this->load->view('admin/includes/footer');
        }
    }

    public function home($page = 'home') {
        $this->session->set_userdata('redirect','');
         
        $username = $this->session->userdata('admin_username');
        $password = $this->session->userdata('admin_password');

        $url = USER_AUTHEDICATE . "?Un=" . $username . "&Pwd=" . $password;
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
        /* Curl Complete */

        if (sizeof($response_data['userprofiledetails']) != 0) {
            //echo "<pre>";
            $userdata['profile'] = array('userID' => $response_data['userprofiledetails'][0]);

            $this->session->set_userdata('profile_picture', $userdata['profile']['userID']['ProfilePICPath']);
            $this->session->set_userdata('user_name', $userdata['profile']['userID']['FirstName'] . ' ' . $userdata['profile']['userID']['LastName']);

            $this->load->view('admin/includes/header');
            $this->load->view('admin/includes/top_header');
            $this->load->view('admin/includes/sidebar');
            //$this->load->view('admin/includes/top-menu');
            $this->load->view('admin/pages/' . $page, $userdata);
            $this->load->view('admin/includes/footer');
        } else {
            $this->session->set_flashdata('Duplicate', 'Please enter valid username & password.');
            redirect(base_url() . "admin/Pages/view");
        }
    }

}

?>
