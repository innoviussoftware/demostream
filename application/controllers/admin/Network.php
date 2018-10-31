<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Network extends CI_Controller {

    public function __construct() {
        parent::__construct();

       // $this->load->library('session');
        //$this->load->library('NingNetwork');
    }

    public function index() {

        $res = $this->session->userdata('login_userdata');
        if ($res['IsAdmin'] != 1) {
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

        $view_data['Userdetail'] = $response_data['UserDetails'];
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_network', $view_data);
        $this->load->view('admin/includes/footer');
    }

    public function GetPaywallList() {
        $network_key = $_POST['network_key'];
        $product_type = 2;
        $ningnetwork = $this->ningnetwork->GetPaywallList($network_key, $product_type);
        if ($ningnetwork['error_code'] == 0 && count($ningnetwork['data']) > 0) {
            $paywalls = $ningnetwork['data'];
            $html = '<option value="">Select Paywall</option>';
            for ($i = 0; $i < sizeof($paywalls); $i++) {
                $paywall = (array) $paywalls[$i];
                $id = $paywall['id'];
                $name = $paywall['name'];
                if ($paywall['type'] == '2') {
                    $html .= '<option value="' . $id . '">' . $name . ' [' . $id . ']</option>';
                }
            }
            echo $html;
        } else {
            echo 0;
        }
    }

    public function GetUserData() {
        $user_id = $this->input->post('UserID');

        $url_u = Userlist;
        $data_u = curl_init();
        curl_setopt($data_u, CURLOPT_URL, $url_u);
        curl_setopt($data_u, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data_u, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data_u, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data_u, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data_u = json_decode(curl_exec($data_u), true);
        $return_u = curl_errno($data_u); //returns 0 if no errors occured
        curl_close($data_u);

        $Userdetail = $response_data_u['UserDetails'];
        $user = array();
        if (sizeof($Userdetail) > 0) {
            for ($i = 0; $i < sizeof($Userdetail); $i++) {
                if ($Userdetail[$i]['UserID'] == $user_id) {
                    $user = $Userdetail[$i];
                    break;
                }
            }
        }

        if (sizeof($user) > 0) {
            $response['account_name'] = $user['AccountName'];
            $response['email'] = $user['EmailID'];

            $response['admin_url'] = '';
            if ($user['NetworkKey'] != 'null' && $user['NetworkKey'] != '') {
                $response['network_key'] = $user['NetworkKey'];
                $network_key = $user['NetworkKey'];
                $ningnetwork = $this->ningnetwork->GetOtpForNetwork($user['EmailID'], $network_key); //email and network key
                if ($ningnetwork['error_code'] == 0) {
                    $response['admin_url'] = $ningnetwork['data'];
                }
            } else {
                $response['network_key'] = '';
            }
            echo json_encode($response);
            exit;
        } else {
            echo '0';
            exit;
        }
    }

    public function AddNewNetwork() {

        if ($this->input->post('submit') != 'submit') {
            redirect(base_url() . 'admin/Network/index');
        }

        $name = $_POST['profile_name'];
        $network_key = $_POST['email'] . '_' . $_POST['user_id'];
        $email = $_POST['email'];
        $expiration_date = date('Y-m-d');

        $user_id = $_POST['user_id'];

        $url_u = Userlist;
        $data_u = curl_init();
        curl_setopt($data_u, CURLOPT_URL, $url_u);
        curl_setopt($data_u, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data_u, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data_u, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data_u, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data_u = json_decode(curl_exec($data_u), true);
        $return_u = curl_errno($data_u); //returns 0 if no errors occured
        curl_close($data_u);

        $Userdetail = $response_data_u['UserDetails'];
        $user = array();
        if (sizeof($Userdetail) > 0) {
            for ($i = 0; $i < sizeof($Userdetail); $i++) {
                if ($Userdetail[$i]['UserID'] == $user_id) {
                    $user = $Userdetail[$i];
                    break;
                }
            }
        }

        if (sizeof($user) > 0) {
            $paywall_id = $this->input->post('paywall');

            $NetworkKey = '';
            if ($network_key != '' && $paywall_id == '') {
              $ningnetwork = $this->ningnetwork->CreateNetwork($network_key, $email, $name, $expiration_date);
              //echo '<pre>';print_r($ningnetwork);
                if ($ningnetwork['error_code'] == 0) {
                    $NetworkKey = $network_key;
                }else{
                      $this->session->set_flashdata('danger', 'Network Added Failed.');
                redirect("admin/Network/index");
                }
            } else {
                $NetworkKey = $user['NetworkKey'];
            }
            //START Adding Product and relation between paywall
            if ($paywall_id != '') {
                $product_key = 'Product_Donate_' . $user_id . rand(0000000, 9999999);
                $product_name = 'Donate Video: ' . $name . '_' . $user_id;
                try {
                    $ning_product = $this->ningnetwork->CreateProductForNetwork($paywall_id, $product_key, $product_name, $network_key, $product_type = 2);
                    $product_id = '';
                    if ($ning_product['error_code'] == 0) {
                        $product_id = $ning_product['data'];
                    }
                    $ning_product_relation = $this->ningnetwork->AddRelationBetweenProductKeyAndPayWall($paywall_id, $product_key, $network_key);
                    $relation_id = '';
                    if ($ning_product_relation['error_code'] == 0) {
                        $relation_id = $ning_product_relation['data'];
                    }
                } catch (Exception $e) {
                    
                }
            }
            //END Adding Product and relation between paywall
            if (@$product_id != '' && @$relation_id != '') {
                $ProductKey = $product_key;
            }
            if ($user['IsAdmin'] == 0) {
                $IsAdmin = 'false';
            } else {
                $IsAdmin = 'true';
            }
            if ($user['IsSuperAdmin'] == 0) {
                $IsSuperAdmin = 'false';
            } else {
                $IsSuperAdmin = 'true';
            }

            $data1 = array(
                "MobileRowOrderNo" => '0',
                "ProfileID" => $user['ProfileID'],
                "UserID" => $user_id,
                "FirstName" => $user['FirstName'],
                "LastName" => $user['LastName'],
                "Region" => $user['Region'],
                "City" => $user['City'],
                "State" => $user['State'],
                "Country" => $user['Country'],
                "ProfilePICPath" => $user['ProfilePICPath'],
                "DeviceID" => $user['DeviceID'],
                "CreatedOnMobile" => $user['CreatedOnMobile'],
                "CreatedOn" => $user['CreatedOn'],
                "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "AccountName" => $user['AccountName'],
                "EmailID" => $user['EmailID'],
                "Password" => $user['Password'],
                "IsSignWithSocialMedia" => 'false',
                "IsAdmin" => $IsAdmin,
                "SubscriptionCharges" => $user['SubscriptionCharges'],
                "TransactionShare" => $user['TransactionShare'],
                "VideoPurchaseShare" => $user['VideoPurchaseShare'],
                "Website" => $user['Website'],
                "Logo" => $user['Logo'],
                "Domain" => $user['Domain'],
                "MobileNo" => $user['MobileNo'],
                "IsSuperAdmin" => $IsSuperAdmin,
                "ProductKey" => @$ProductKey,
                "NetworkKey" => @$NetworkKey,
                "PaywallId" => $paywall_id
            );

            $datajson1['userprofiledetails'][0] = $data1;
            $data_string1 = json_encode($datajson1);
            $data_string1 = str_replace("\\/", "/", $data_string1);

            $url1 = SYNCTODB;
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            $response_data = json_decode(curl_exec($ch1), true);
            $return = curl_errno($ch1);
            
            if ($return == 0) {
                
                $this->session->set_flashdata('success', 'Network Added Successfully.');
                redirect("admin/Network/index");
            } else {
                $this->session->set_flashdata('danger', 'Network Added Failed.');
                redirect("admin/Network/index");
            }
        } else {
            $this->session->set_flashdata('danger', 'Network Added Failed.');
            redirect("admin/Network/index");
        }
    }

    public function ViewAllNetworks() {
        $url_u = Userlist;
        $data_u = curl_init();
        curl_setopt($data_u, CURLOPT_URL, $url_u);
        curl_setopt($data_u, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data_u, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data_u, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data_u, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data_u = json_decode(curl_exec($data_u), true);
        $return_u = curl_errno($data_u); //returns 0 if no errors occured
        curl_close($data_u);

        $Userdetail = $response_data_u['UserDetails'];
        $view_data['users'] = array();
        if (sizeof($Userdetail) > 0) {
            $view_data['users'] = $Userdetail;
        }

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_network', $view_data);
        $this->load->view('admin/includes/footer');
    }

    public function UpdatePayemtStatus() {
        $network_key = $this->input->post('network_key');
        $payment_status = $this->input->post('payment_status');
        $user_id = $this->input->post('user_id');

        if ($payment_status == '0') {
            $payment_status = 'false';
        } else {
            $payment_status = 'true';
        }

        $data1 = array(
            "MobileRowOrderNo" => '0',
            "ProfileID" => $user['ProfileID'],
            "UserID" => $user_id,
            "FirstName" => $user['FirstName'],
            "LastName" => $user['LastName'],
            "Region" => $user['Region'],
            "City" => $user['City'],
            "State" => $user['State'],
            "Country" => $user['Country'],
            "ProfilePICPath" => $user['ProfilePICPath'],
            "DeviceID" => $user['DeviceID'],
            "CreatedOnMobile" => $user['CreatedOnMobile'],
            "CreatedOn" => $user['CreatedOn'],
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "AccountName" => $user['AccountName'],
            "EmailID" => $user['EmailID'],
            "Password" => $user['Password'],
            "IsSignWithSocialMedia" => 'false',
            "IsAdmin" => $user['IsAdmin'],
            "SubscriptionCharges" => $user['SubscriptionCharges'],
            "TransactionShare" => $user['TransactionShare'],
            "VideoPurchaseShare" => $user['VideoPurchaseShare'],
            "Website" => $user['Website'],
            "Logo" => $user['Logo'],
            "Domain" => $user['Domain'],
            "MobileNo" => $user['MobileNo'],
            "IsSuperAdmin" => $user['IsSuperAdmin'],
            "ProductKey" => $user['ProductKey'],
            "NetworkKey" => $user['NetworkKey'],
            "Payment_enabled" => $payment_status
        );

        $datajson1['userprofiledetails'][0] = $data1;
        $data_string1 = json_encode($datajson1);
        $data_string1 = str_replace("\\/", "/", $data_string1);

        $url1 = SYNCTODB;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        $response_data = curl_exec($ch1);
        $return = curl_errno($ch1);

        if ($return == 0) {
            echo 0;
            exit;
        } else {
            echo 1;
            exit;
        }
    }
}