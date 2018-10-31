<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('hybridauth');
        $this->load->library('session');
        $this->load->library('email');
    }

    public function login() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        //$password=md5($password);

        $url = USER_AUTHEDICATE . "?Un=" . $username . "&Pwd=" . $password;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 80);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response_data = json_decode(curl_exec($ch), true);
        $return = curl_errno($ch);

        //  curl_close($ch);

        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo " {$error_message}";
        }
        curl_close($ch);


        // echo '<pre>';print_r($response_data);exit;
        /* Curl Complete */
        if (sizeof($response_data['userprofiledetails']) != 0) {
            $userdata = array('userID' => $response_data['userprofiledetails'][0]);
            $subscribed = $response_data['subscription'];
            $this->session->set_userdata('login_userdata', $userdata['userID']);
            $this->session->set_userdata('subscription', $subscribed);
            //  $iscampaign = $this->session->userdata['iscampaign'];
            $Video_ID = $this->session->userdata('Video_ID');

            /* START USE FOR ADMIN PANEL */
            if (sizeof($response_data['subscription']) != 0) {
                //echo "aa";

                $this->session->set_userdata('subscription_admin', $response_data['subscription']);
            }
            $sub = array();
            if (isset($response_data['userprofiledetails'][1]['SubscriptionCharges'])) {
                $sub = $response_data['userprofiledetails'][1]['SubscriptionCharges'];
            }
            $this->session->set_userdata('SubscriptionCharges', $sub);
            if (isset($response_data['userprofiledetails'][1]['UserID']) != 1) {
                $response_data['userprofiledetails'][1]['UserID'] = 1;
            }
            if (isset($response_data['userprofiledetails'][1])) {
                $this->session->set_userdata('dealer_data', $response_data['userprofiledetails'][1]);
            }
            $this->session->set_userdata('first_name', $response_data['userprofiledetails'][0]['FirstName']);
            $this->session->set_userdata('admin_username', $username);
            $this->session->set_userdata('admin_password', $password);
            $this->session->set_userdata('IsSuperAdmin', 0);
            if (isset($response_data['userprofiledetails'][0]['IsSuperAdmin'])) {
                $this->session->set_userdata('IsSuperAdmin', $response_data['userprofiledetails'][0]['IsSuperAdmin']);
            }

            $redirect = $this->session->userdata('redirect');

            if ($redirect == '0') {
                redirect(base_url() . 'admin/Pages/home');
            } elseif ($redirect == '2') {
                redirect(base_url() . 'Video_curl/comments_donors/' . $Video_ID . '/' . $Video_ID . "/comments");
            } elseif ($redirect == '5') {
                $vid = $this->session->userdata('vid');
                $uid = $this->session->userdata('uid');
                redirect(base_url() . 'Video_curl/video/' . $vid);
            } else {
                /* END USE FOR ADMIN PANEL */

                redirect(base_url() . 'Video_curl/video/' . $Video_ID);
            }
        } else {
            $this->session->set_flashdata('Duplicate', 'Please enter valid username & password.');
            redirect(base_url() . "Hauth/users");
        }
    }

    public function register($type) {
        $firstname = '';
        $lastname = '';
        $email = '';
        $city = '';
        $region = '';
        $password1 = '';
        $creadtedonmobile = '';
        $profileId = '';
        $profile_path = '';
        $sync = '';
        $sign_social = '';
        $id = '';
        if ($type == '') {
            $type = 0;
        }
        /* 		Register Type 0-Email  1-Facebook  2-GooglePlus  3-Twitter		 */
//************* Start Register with Email-ID*****************************//

        if ($type == 0) {
            $firstname = $this->input->post('name');
            $email = $this->input->post('email-address');
            $city = $this->input->post('city');

            $password1 = $this->input->post('password1');
            $password2 = $this->input->post('password2');
            $creadtedonmobile = date('Y-m-d h:i:s');

            $profileId = round(microtime(true));
            $sync = 'false';
            $sign_social = 'false';
        } elseif ($type == 2 || $type == 3) {
//*************************Start Register using  GooglePlus/ Twitter*************************//
            $social_data = $this->session->userdata['profile_data']['profile'];

            $firstname = $social_data['firstName'];
            $lastname = $social_data['lastName'];
            $email = $social_data['email'];
            $city = $social_data['city'];
            $region = $social_data['region'];
            $password1 = $social_data['identifier'];
            $creadtedonmobile = date('Y-m-d h:i:s');
            $id = round(microtime(true));
            $profileId = round(microtime(true));
            $profile_path = $social_data['photoURL'];
            $sync = 'false';
            $sign_social = 'true';
        } elseif ($type == 1) {
            $profile_data = $this->session->userdata('profile_data');

            $social_data = $this->session->userdata['profile_data']['profile'];

            if (isset($social_data['first_name'])) {
                $firstname = $social_data['first_name'];
            }if (isset($social_data['last_name'])) {
                $lastname = $social_data['last_name'];
            }if (isset($social_data['email'])) {
                $email = $social_data['email'];
            }if (isset($social_data['id'])) {
                $id = $social_data['id'];
            }
            $city = '';
            $region = '';
            $password1 = '';
            $creadtedonmobile = date('Y-m-d h:i:s');

            $profileId = round(microtime(true));
            $profile_path = 'https://graph.facebook.com/' . $social_data["id"] . '/picture';
            $sync = 'false';
            $sign_social = 'true';
        } else {
            
        }


        $data = array(
            "ProfileID" => 0,
            "UserID" => $profileId,
            "FirstName" => $firstname,
            "LastName" => $lastname,
            "Region" => $region,
            "City" => $city,
            "State" => '',
            "Country" => '',
            "ProfilePICPath" => $profile_path,
            "DeviceID" => '',
            "CreatedOnMobile" => $creadtedonmobile,
            "CreatedOn" => $creadtedonmobile,
            "UpdatedOn" => $creadtedonmobile,
            "UpdatedOnMobile" => $creadtedonmobile,
            "MobileRowOrderNo" => 3,
            "AccountName" => $firstname,
            "EmailID" => $email,
            "Password" => $password1,
            "IsSignWithSocialMedia" => $sign_social,
            "IsAdmin" => "false",
            "SubscriptionCharges" => "0",
            "VideoPurchaseShare" => '',
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
        $return = curl_errno($ch); //returns 0 if no errors occured

        if ($return == 0) {
            redirect(base_url() . "Video_curl/video");
        } else {
            redirect('Hauth/users/register');
        }

        curl_close($ch);
    }

    public function forgot_password() {
        $this->load->view('includes/header');
        $this->load->view('includes/top-menu');
        $this->load->view('pages/forgot_password');
        $this->load->view('includes/footer');
    }

    public function forgot_pass() {
        $email = $this->input->post('email');
        $url = Forgot_password . "?Un=" . $email;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 80);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response_data = json_decode(curl_exec($ch), true);

        //echo "<pre>";print_r($response_data);
        $userid['userid'] = $response_data['userprofiledetails'][0];
        $this->load->view('includes/header');
        $this->load->view('includes/top-menu');
        $this->load->view('pages/reset_password', $userid);
        $this->load->view('includes/footer');
    }

    public function reset_pass() {
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
        // echo '<pre>';print_r($data);exit;
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
        //echo $return;exit;
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
        $this->session->sess_destroy();
        redirect(base_url() . "Video_curl/campaign");
    }

}
