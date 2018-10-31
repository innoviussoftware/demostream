<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('hybridauth');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->model('Upload');
    }

    public function login() {

//        $username = $this->input->post('username');
//        $password = $this->input->post('password');
//
//        $url = USER_AUTHEDICATE . "?Un=" . $username . "&Pwd=" . $password;
//        $data = curl_init();
//        curl_setopt($data, CURLOPT_URL, $url);
//        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
//        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
//        $response_data = json_decode(curl_exec($data), true);
//        $return = curl_errno($data); //returns 0 if no errors occured
//        curl_close($data);
//        //echo '<pre>';print_r($response_data);exit;
//        /* Curl Complete */
//        if (sizeof($response_data['userprofiledetails']) != 0) {
//
//            $userdata = array('userID' => $response_data['userprofiledetails'][0]);
//
//            if (sizeof($response_data['subscription']) != 0) {
//                //echo "aa";
//
//                $this->session->set_userdata('subscription', $response_data['subscription']);
//            }
//            $sub = $response_data['userprofiledetails'][1]['SubscriptionCharges'];
//            $this->session->set_userdata('SubscriptionCharges', $sub);
//            $this->session->set_userdata('login_userdata', $userdata['userID']);
//
//            if ($response_data['userprofiledetails'][1]['UserID'] != 1) {
//                $response_data['userprofiledetails'][1]['UserID'] = 1;
//            }
//            $this->session->set_userdata('dealer_data', $response_data['userprofiledetails'][1]);
//
//
//            $this->session->set_userdata('first_name', $response_data['userprofiledetails'][0]['FirstName']);
//            $this->session->set_userdata('admin_username', $username);
//            $this->session->set_userdata('admin_password', $password);
//            $this->session->set_userdata('IsSuperAdmin', $response_data['userprofiledetails'][0]['IsSuperAdmin']);
//
//            //exit;
//            redirect(base_url() . "admin/Pages/home");
//        } else {
//            $this->session->set_flashdata('Duplicate', 'Please enter valid username & password.');
//            redirect(base_url() . "admin/Pages/view");
//        }
    }

    public function edit_profile() {


        
        $FirstName = $this->input->post('FirstName');
        $LastName = $this->input->post('LastName');
        $AccountName = $this->input->post('AccountName');
        $City = $this->input->post('City');
        $State = $this->input->post('State');
        $Country = $this->input->post('Country');
        $ProfileID = $this->input->post('ProfileID');
        $UserID = $this->input->post('UserID');
        $DeviceID = $this->input->post('DeviceID');
        $CreatedOnMobile = $this->input->post('CreatedOnMobile');
        $CreatedOn = $this->input->post('CreatedOn');
        $UpdatedOnMobile = $this->input->post('UpdatedOnMobile');
        $UpdatedOn = $this->input->post('UpdatedOn');
        $MobileRowOrderNo = $this->input->post('MobileRowOrderNo');
        $EmailID = $this->input->post('EmailID');
        $Password = $this->input->post('Password');
        $IsSignWithSocialMedia = $this->input->post('IsSignWithSocialMedia');
        $SubscriptionCharges = $this->input->post('SubscriptionCharges');
        $TransactionShare = $this->input->post('TransactionShare');
        $VideoPurchaseShare = $this->input->post('VideoPurchaseShare');
        $Region = $this->input->post('Region');
        $IsAdmin = $this->input->post('IsAdmin');
        $IsSuperAdmin = $this->input->post('IsSuperAdmin');

        if ($IsSuperAdmin == 1) {
            $IsSuperAdmin = 'true';
        } else {
            $IsSuperAdmin = 'false';
        }

        if ($IsAdmin == 1) {
            $IsAdmin = 'true';
        } else {
            $IsAdmin = 'false';
        }
        $uploaded = $this->Upload->do_upload_profile('userfile');

        $file_name = '';
        $file_desc = '';
        if (!isset($uploaded['error'])) {
            $file_name = $uploaded['upload_data']['file_name'];
        } else {
            $file_name = $this->input->post('ProfilePICPath');
        }

        $data = array(
            "MobileRowOrderNo" => $MobileRowOrderNo,
            "ProfileID" => $ProfileID,
            "UserID" => $UserID,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "Region" => 'a',
            "City" => $City,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => $file_name,
            "DeviceID" => $DeviceID,
            "CreatedOnMobile" => $CreatedOnMobile,
            "CreatedOn" => $CreatedOn,
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "AccountName" => $AccountName,
            "EmailID" => $EmailID,
            "Password" => $Password,
            "IsSignWithSocialMedia" => 'false',
            "IsAdmin" => $IsAdmin,
            "IsSuperAdmin" => $IsSuperAdmin,
            "SubscriptionCharges" => $SubscriptionCharges,
            "TransactionShare" => $TransactionShare,
            "VideoPurchaseShare" => $VideoPurchaseShare,
            "Website" => '',
            "Logo" => '',
            "Domain" => '',
            "MobileNo" => ''
        );

        $profiles = $this->session->userdata('profile_data');
        $datajson['userprofiledetails'][0] = $data;
        $data_string = json_encode($datajson);
        $data_string = str_replace("\\/", "/", $data_string);

        $url = SYNCTODB;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response_data = curl_exec($ch);
        $return = curl_errno($ch);
        if ($return == 0) {
            $this->session->set_userdata('profile_picture', $file_name);
            $this->session->set_flashdata('success', 'Profile Changed Successfully.');
            redirect(base_url() . "admin/Pages/home");
        } else {
            $this->session->set_flashdata('success', 'Profile Changed Failed.');
            redirect(base_url() . "admin/Pages/home");
        }

        curl_close($ch);
    }

    public function reset_password() {

        // $user = $this->session->userdata('login_userdata');
        // $UserID = $user['UserID'];

        //$old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('c_password');

        if ($new_password == $confirm_password) {
            $Password = $new_password;
        }

        $FirstName = $this->input->post('FirstName');
        $LastName = $this->input->post('LastName');
        $AccountName = $this->input->post('AccountName');
        $City = $this->input->post('City');
        $State = $this->input->post('State');
        $Country = $this->input->post('Country');
        $ProfileID = $this->input->post('ProfileID');
        $UserID = $this->input->post('UserID');
        $DeviceID = $this->input->post('DeviceID');
        $ProfilePICPath = $this->input->post('ProfilePICPath');
        $CreatedOnMobile = $this->input->post('CreatedOnMobile');
        $CreatedOn = $this->input->post('CreatedOn');
        $UpdatedOnMobile = date('Y-m-d h:i:s');
        $UpdatedOn = $this->input->post('UpdatedOn');
        $MobileRowOrderNo = $this->input->post('MobileRowOrderNo');
        $EmailID = $this->input->post('EmailID');
        $Password = $Password;
        $IsSignWithSocialMedia = $this->input->post('IsSignWithSocialMedia');
        $SubscriptionCharges = $this->input->post('SubscriptionCharges');
        $TransactionShare = $this->input->post('TransactionShare');
        $VideoPurchaseShare = $this->input->post('VideoPurchaseShare');
        $Region = $this->input->post('Region');
        $IsAdmin = $this->input->post('IsAdmin');

        $data = array(
            "MobileRowOrderNo" => $MobileRowOrderNo,
            "ProfileID" => $ProfileID,
            "UserID" => $UserID,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "Region" => $Region,
            "City" => $City,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => $ProfilePICPath,
            "DeviceID" => $DeviceID,
            "CreatedOnMobile" => $CreatedOnMobile,
            "CreatedOn" => $CreatedOn,
            "UpdatedOn" => $UpdatedOn,
            "UpdatedOnMobile" => $UpdatedOnMobile,
            "AccountName" => $AccountName,
            "EmailID" => $EmailID,
            "Password" => $Password,
            "IsSignWithSocialMedia" => $IsSignWithSocialMedia,
            "IsAdmin" => $IsAdmin,
            "SubscriptionCharges" => $SubscriptionCharges,
            "TransactionShare" => $TransactionShare);

        $profiles = $this->session->userdata('profile_data');
        //echo '<pre>';print_r($data);exit;
        $datajson['userprofiledetails'][0] = $data;
        $data_string = json_encode($datajson);
        $data_string = str_replace("\\/", "/", $data_string);

        $url = SYNCTODB;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response_data = curl_exec($ch);
        $return = curl_errno($ch);
        if ($return == 0) {
            $this->session->set_flashdata('success', 'Password Changed Successfully.');

            $password = $this->session->set_userdata('admin_password', $Password);
            redirect(base_url() . "admin/Pages/home");
        } else {
            $this->session->set_flashdata('danger', 'Password Changed Failed.');

            redirect(base_url() . "admin/Pages/home");
        }

        curl_close($ch);
    }

    public function logout() {
        unset($_SESSION);
        $this->session->sess_destroy();
        redirect(base_url() . "admin/Pages/view");
    }

}

?>