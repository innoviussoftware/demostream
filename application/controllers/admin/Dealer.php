<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Upload');
    }

    public function add_dealer() {
        $res = $this->session->userdata('login_userdata');
        if ($res['IsSuperAdmin'] != 1) {
            show_404();
            exit;
        }

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_dealer');
        $this->load->view('admin/includes/footer');
    }

    public function add_subscription() {
        $res = $this->session->userdata('login_userdata');
        if ($res['IsSuperAdmin'] != 1) {
            show_404();
            exit;
        }

        $url = Userlist;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);
        //echo "<pre>";print_r($response_data);exit;
        $Userdetail['Userdetail'] = $response_data['UserDetails'];
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_subscription', $Userdetail);
        $this->load->view('admin/includes/footer');
    }

    public function add_new_dealer() {
        $res = $this->session->userdata('login_userdata');
        if ($res['IsSuperAdmin'] != 1) {
            show_404();
            exit;
        }

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        $uploaded = $this->Upload->do_upload('userfile');
        @$file_name = $uploaded['userfile']['file_name'];

        if (!isset($uploaded['error'])) {
            $Profilepic = base_url() . 'uploads/' . $uploaded['upload_data']['file_name'];
        } else {
            $Profilepic = '';
        }

        $DeviceID = round(microtime(true));

        @$filename = $uploaded['upload_data']['file_name'];

        $uploaded_logo = $this->Upload->do_upload_logo('logo');
        $logo_name = '';
        if (!isset($uploaded_logo['error'])) {
            $logo_name = $uploaded_logo['upload_data']['file_name'];
        } else {
            $logo_name = '';
        }
        $logo_path = $uploaded['upload_data']['file_path'];

        $domain = $this->input->post('firstname');
        $FirstName = $this->input->post('firstname');
        $LastName = $this->input->post('lastname');
        $emailid = $this->input->post('emailid');
        $password = $this->input->post('password');
        $city = $this->input->post('city');
        $State = $this->input->post('state');
        $Country = $this->input->post('country');
        $phone = $this->input->post('phone');
        $WebServiceURL = $this->input->post('WebServiceURL');
        $userfile = $filename;
        $account_name = $this->input->post('account_name');
        $sub_charge = $this->input->post('sub_charge');
        $transaction_share = $this->input->post('transaction_share');
        $VideoPurchaseShare = $this->input->post('VideoPurchaseShare');
        $DBServerName = $this->input->post('DBServerName');
        $DBName = $this->input->post('DBName');
        $DBUserName = $this->input->post('DBUserName');
        $DBPassword = $this->input->post('DBPassword');
        $SubFromDate = $this->input->post('SubFromDate');
        $SubEndDate = $this->input->post('SubEndDate');
if($sub_charge == ''){
$sub_charge = 0;
}
if($transaction_share == ''){
$transaction_share = 0;
}
if($VideoPurchaseShare == ''){
$VideoPurchaseShare = 0;
}

        $data1 = array(
            "DealerID" => 0,
            "DealerDetID" => 0,
            "Logo" => $logo_name,
            "DBServerName" => $DBServerName,
            "DBName" => $DBName,
            "DBUserName" => $DBUserName,
            "DBPassword" => $DBPassword,
            "Domain" => $domain,
            "WebServiceURL" => $WebServiceURL,
            "CreatedBy" => $UserID,
            "CreatedOn" => date('Y-m-d h:i:s'),
            "ModifyBy" => 0,
            "ModifyOn" => date('Y-m-d h:i:s'),
            "SubFromDate" => $SubFromDate,
            "SubEndDate" => $SubEndDate,
            "IsActive" => 'true',
            "IsDelete" => 'false',
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "City" => $city,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => $Profilepic,
            "AccountName" => $account_name,
            "EmailID" => $emailid,
            "Password" => $password,
            "IsAdmin" => "false",             
            "SubscriptionCharges" => $sub_charge,
            "TransactionShare" => $transaction_share,
            "VideoPurchaseShare" => $VideoPurchaseShare
        );

        //echo "<pre>";print_r($data1);
        $datajson1['dealerdetails'][0] = $data1;
        $data_string1 = json_encode($datajson1);
 $data_string1 = str_replace("\\/", "/", $data_string1);

        $url1 = SYNCTOCONFIGDB;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        $response_data = curl_exec($ch1);
      //  print_r($response_data);
      //  exit;
        $return = curl_errno($ch1);
        $this->session->set_flashdata('success', 'Dealer Added Successfully.');
        redirect(base_url() . "admin/Dealer/add_dealer");
    }

    public function view_dealers() {
        $res = $this->session->userdata('login_userdata');
        if ($res['IsSuperAdmin'] != 1) {
            show_404();
            exit;
        }

        $url = DEALER_LIST;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $dealer['dealers'] = $response_data['dealerdetails'];

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_dealers', $dealer);
        $this->load->view('admin/includes/footer');
    }

    public function edit_dealer($edit_id) {
        $res = $this->session->userdata('login_userdata');
        if ($res['IsSuperAdmin'] != 1) {
            show_404();
            exit;
        }

        $url = DEALER_LIST;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $dealer = $response_data['dealerdetails'];

        if (sizeof($dealer) > 0) {
            for ($i = 0; $i < sizeof($dealer); $i++) {
                if ($dealer[$i]['DealerID'] == $edit_id) {
                    $edit_dealer['edit_dealer'] = $dealer[$i];
                    break;
                }
            }
        }
//        echo "<pre>";print_r($edit_user);exit;
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/edit_dealer', $edit_dealer);
        $this->load->view('admin/includes/footer');
    }

    public function update_dealer() {
        $res = $this->session->userdata('login_userdata');
        if ($res['IsSuperAdmin'] != 1) {
            show_404();
            exit;
        }

        $UserID = $this->input->post('DealerID');

        $url = DEALER_LIST;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $dealer = $response_data['dealerdetails'];

        if (sizeof($dealer) > 0) {
            for ($i = 0; $i < sizeof($dealer); $i++) {
                if ($dealer[$i]['DealerID'] == $UserID) {
                    $edit_dealer = $dealer[$i];
                    break;
                }
            }
        }

        $user = $this->session->userdata('login_userdata');


        $uploaded = $this->Upload->do_upload('userfile');

        $Profilepic = '';

        if (!isset($uploaded['error'])) {
            @$Profilepic = $uploaded['upload_data']['file_name'];
        } else {
            $Profilepic = $edit_dealer['ProfilePICPath'];
        }


        $uploaded_logo = $this->Upload->do_upload_logo('logo');
        $logo_name = '';
        if (!isset($uploaded_logo['error'])) {
            @$logo_name = $uploaded_logo['upload_data']['file_name'];
        } else {
            $logo_name = $edit_dealer['Logo'];
        }
//        print_r($uploaded_logo);exit;

        $domain = $this->input->post('domain');
        $FirstName = $this->input->post('firstname');
        $LastName = $this->input->post('lastname');
        $emailid = $this->input->post('emailid');
        $password = $this->input->post('password');
        $city = $this->input->post('city');
        $State = $this->input->post('state');
        $Country = $this->input->post('country');
        $phone = $this->input->post('phone');
        $WebServiceURL = $this->input->post('WebServiceURL');

        $account_name = $this->input->post('account_name');
        $sub_charge = $this->input->post('sub_charge');
        $transaction_share = $this->input->post('transaction_share');
        $VideoPurchaseShare = $this->input->post('VideoPurchaseShare');
        $DBServerName = $this->input->post('DBServerName');
        $DBName = $this->input->post('DBName');
        $DBUserName = $this->input->post('DBUserName');
        $DBPassword = $this->input->post('DBPassword');
        $SubFromDate = $this->input->post('SubFromDate');
        $SubFromDate = date('Y-m-d', strtotime($SubFromDate));
        $SubEndDate = $this->input->post('SubEndDate');
        $SubEndDate = date('Y-m-d', strtotime($SubEndDate));

if($sub_charge == ''){
$sub_charge = 0;
}
if($transaction_share == ''){
$transaction_share = 0;
}
if($VideoPurchaseShare == ''){
$VideoPurchaseShare = 0;
}

        $data1 = array(
            "DealerID" => $this->input->post('DealerID'),
            "DealerDetID" => $edit_dealer['DealerDetID'],
            "Logo" => $logo_name,
            "DBServerName" => $DBServerName,
            "DBName" => $DBName,
            "DBUserName" => $DBUserName,
            "DBPassword" => $DBPassword,
            "Domain" => $domain,
            "WebServiceURL" => $WebServiceURL,
            "CreatedBy" => $edit_dealer['UserID'],
            "CreatedOn" => date('Y-m-d h:i:s'),
            "ModifyBy" => 0,
            "ModifyOn" => date('Y-m-d h:i:s'),
            "SubFromDate" => $SubFromDate,
            "SubEndDate" => $SubEndDate,
            "IsActive" => 'true',
            "IsDelete" => 'false',
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "City" => $city,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => $Profilepic,
            "AccountName" => $account_name,
            "EmailID" => $emailid,
            "Password" => $password,
            "IsAdmin" => "false",
            "SubscriptionCharges" => $sub_charge,
            "TransactionShare" => $transaction_share,
            "VideoPurchaseShare" => $VideoPurchaseShare
        );


        $datajson1['dealerdetails'][0] = $data1;
        $data_string1 = json_encode($datajson1);
        $data_string1 = str_replace("\\/", "/", $data_string1);
        //exit;
        $url1 = SYNCTOCONFIGDB;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        $response_data = curl_exec($ch1);
//        echo '<pre>';        print_r($response_data);exit;

        $return = curl_errno($ch1);
        $this->session->set_flashdata('success', 'Dealer Updated Successfully.');
        redirect(base_url() . "admin/Dealer/view_dealers");
    }

}

?>
