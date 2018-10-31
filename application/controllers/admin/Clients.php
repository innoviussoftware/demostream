<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Upload');
    }

    public function add_clients() {

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_client');
        $this->load->view('admin/includes/footer');
    }

    public function add_logo() {

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_logo');
        $this->load->view('admin/includes/footer');
    }

    public function add_package() {

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_package');
        $this->load->view('admin/includes/footer');
    }

    public function add_subscription() {
        //$url = Userlist;
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
        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];

        $url1 = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data1 = curl_init();

        curl_setopt($data1, CURLOPT_URL, $url1);
        curl_setopt($data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data1, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data1), true);
        $return = curl_errno($data1); //returns 0 if no errors occured
        curl_close($data1);


        $data_pass['Userdetail'] = $response_data['UserDetails'];
        $data_pass['package'] = $response_data1['subscriptionpackage'];

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_subscription', $data_pass);
        $this->load->view('admin/includes/footer');
    }

    public function edit_view_subscription($id) {
        $url = Subscriptionlist;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);
        $subdata = sizeof($response_data['subscription']);

        for ($r = 0; $r < $subdata; $r++) {
            if ($response_data['subscription'][$r]['SubscriptionId'] == $id) {
                $subscription_detail = $response_data['subscription'][$r];
                break;
            }
        }
        $url1 = Userlist;

        $data1 = curl_init();
        curl_setopt($data1, CURLOPT_URL, $url1);
        curl_setopt($data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data1, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data1), true);
        $return = curl_errno($data1); //returns 0 if no errors occured
        curl_close($data1);



        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];

        $url2 = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data2 = curl_init();

        curl_setopt($data2, CURLOPT_URL, $url2);
        curl_setopt($data2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data2, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data2, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data2, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data2 = json_decode(curl_exec($data2), true);
        $return = curl_errno($data2); //returns 0 if no errors occured
        curl_close($data2);


        $data_pass['Userdetail'] = $response_data1['UserDetails'];

        $data_pass['subscription_detail'] = $subscription_detail;

        $data_pass['package'] = $response_data2['subscriptionpackage'];


        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_subscription', $data_pass);
        $this->load->view('admin/includes/footer');
    }

    public function add_new_clients() {

        $uploaded = $this->Upload->do_upload('userfile');
        @$file_name = $uploaded['userfile']['file_name'];
        $file_desc = json_encode($uploaded);
        $file_desc = str_replace("\\/", "/", $file_desc);

        $Profilepic = base_url() . 'uploads/' . $uploaded['upload_data']['file_name'];
        $UserId = round(microtime(true));
        $DeviceID = round(microtime(true));

        @$filename = $uploaded['upload_data']['file_name'];

        $uploaded = $this->Upload->do_upload_logo('logo');
        $file_desc = json_encode($uploaded);
        $file_desc = str_replace("\\/", "/", $file_desc);
        $logo_name = $uploaded['upload_data']['file_name'];
        //exit;
        $logo_path = $uploaded['upload_data']['file_path'];

        $domain = $this->input->post('firstname');
        $FirstName = $this->input->post('firstname');
        $LastName = $this->input->post('lastname');
        $eid = $this->input->post('emailid');
        $password = $this->input->post('password');
        $city = $this->input->post('city');
        $State = $this->input->post('state');
        $Country = $this->input->post('country');
        $phone = $this->input->post('phone');
        $website = $this->input->post('website');
        $userfile = $filename;
        $account_name = $this->input->post('account_name');
        $sub_charge = $this->input->post('sub_charge');
        $transaction_share = $this->input->post('transaction_share');
        $VideoPurchaseShare = $this->input->post('VideoPurchaseShare');

        $emailid = $eid;
        $data1 = array(
            "ProfileID" => 0,
            "UserID" => 0,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "Region" => '',
            "City" => $city,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => $Profilepic,
            "DeviceID" => $DeviceID,
            "CreatedOnMobile" => date('Y-m-d h:i:s'),
            "CreatedOn" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "MobileRowOrderNo" => 0,
            "AccountName" => $account_name,
            "EmailID" => $emailid,
            "Password" => $password,
            "IsSignWithSocialMedia" => '',
            "IsAdmin" => 0,
            "SubscriptionCharges" => $sub_charge,
            "TransactionShare" => $transaction_share,
            "VideoPurchaseShare" => $VideoPurchaseShare,
            "Website" => $website,
            "Logo" => $logo_name . $logo_path,
            "Domain" => $domain,
            "MobileNo" => $phone,
            "IsSuperAdmin" => "false"
        );

        $datajson1['userprofiledetails'][0] = $data1;
        $data_string1 = json_encode($datajson1);
        $data_string1 = str_replace("\\/", "/", $data_string1);
        //exit;
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


        $subject = 'Demostream | Website';

        // $body = "Name : $name<br>Email : $email<br>Phone : $phone<br>Message : $message";
        if ($FirstName == '') {
            $FirstName = 'user';
        }
        if ($return == 0) {
            $message = '<html><body>';
            $message .= '<b>Hello ' . $FirstName . ', <br>Your details are added into demostream data Kindly login with below email id and password..</b><br><br>';
            $message .= '<table>';
            $message .= '<tr><td><b>Email :</b></td><td>' . $emailid . '</td></tr>';
            $message .= '<tr><td><b>Password :</b></td><td>' . $password . '</td></tr>';
            $message .= '</table><br><br><br>Thank You<br>website: http://demostream.tv<br><br>';
            $message .= '</body></html>';


            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(FROM_MAIL, 'Demostream');
            $this->email->to($emailid);
            $this->email->set_mailtype("html");
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
            $this->email->print_debugger();

            $this->session->set_flashdata('success', 'Client Added Successfully.');
        } else {
            $this->session->set_flashdata('success', 'Client Added Failed.');
        }
        redirect(base_url() . "admin/Clients/add_clients");
    }

    public function add_new_subscription() {

       $PackageID = $this->input->post('PackageID');
        $SubscriptionId = round(microtime(true));
        $subscription_date = $this->input->post('subscription_date');

        $TransactionId = $this->input->post('TransactionId');
        $user_id = $this->input->post('user_id');
        $InvoiceId = $this->input->post('InvoiceId');

        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];

        $url_package = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data_package = curl_init();

        curl_setopt($data_package, CURLOPT_URL, $url_package);
        curl_setopt($data_package, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data_package, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data_package, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data_package, CURLOPT_SSL_VERIFYPEER, 0);
        $response_datap = json_decode(curl_exec($data_package), true);
        $returnp = curl_errno($data_package); //returns 0 if no errors occured
        curl_close($data_package);

        $select_pack = array();
        $package_data = $response_datap['subscriptionpackage'];
        if (sizeof($package_data) > 0) {
            for ($i = 0; $i < sizeof($package_data); $i++) {
                if ($package_data[$i]['PackageID'] == $PackageID) {
                    $select_pack = $package_data[$i];
                    break;
                }
            }
        }
        $selected_pack = $select_pack;

        $SubscriptionAmount = $selected_pack['PackAmount'];
        $days = round($selected_pack['NoOfDays']);

        $SubFromDate = date('Y-m-d', strtotime($subscription_date));
        $SubEndDate = date('Y-m-d', strtotime('+' . $days . 'months', strtotime($SubFromDate)));

        $data = array
            (
            "SubscriptionId" => 0,
            "UserId" => $user_id,
            "PackageID" => $PackageID,
            "SubscriptionDate" => $subscription_date,
            "SubscriptionAmount" => $SubscriptionAmount,
            "IsSubscribed" => 'true',
            "TransactionId" => $TransactionId,
            "InvoiceId" => $InvoiceId,
            "CreatedOnMobile" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "IsSync" => 'false',
            "SubFromDate" => $SubFromDate,
            "SubEndDate" => $SubEndDate
        );
              
        $datajson['subscription'][0] = $data;
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
            $emailid = $user['EmailID'];
            $subject = 'Your subscription has been added | Demostream';

            $body = "Please check your details by login above email id and password.";

            $message = '<html><body>';
            $message .= '<b>Hello ' . $user['FirstName'] . ', <br>you are successfully subscribed for ' . $days . ' months at demostream.</b><br><br>';
            $message .= '<table>';
            $message .= '<tr><td><b>Subscription Date :</b>' . $subscription_date . '</td></tr>';
            $message .= '<tr><td><b>Package :</b>' . $select_pack['PackageName'] . '</td></tr>';
            $message .= '<tr><td><b>Package amount :</b>' . $SubscriptionAmount . '</td></tr><br>';
            $message .= '</table><br><br><br>Thank You<br>website: http://demostream.tv<br><br>';
            $message .= '</body></html>';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('jinal.innovius@gmail.com', 'Demostream | website');
            $this->email->to($emailid);
            $this->email->set_mailtype("html");
            $this->email->subject($subject);
            $this->email->message($message);
           $this->email->send();
            $this->email->print_debugger();
            $this->session->set_flashdata('success', 'Subscription Added Successfully.');
            redirect(base_url() . "admin/Clients/add_subscription");
        } else {
            $this->session->set_flashdata('danger', 'Subscription Added Failed.');
            redirect(base_url() . "admin/Clients/add_subscription");
        }
    }

    public function edit_subscription() {

        $PackageID = $this->input->post('PackageID');
        $SubscriptionId = $this->input->post('SubscriptionId');
        $subscription_date = $this->input->post('subscription_date');

        $TransactionId = $this->input->post('TransactionId');
        $user_id = $this->input->post('user_id');
        $InvoiceId = $this->input->post('InvoiceId');



        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];

        $url_package = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data_package = curl_init();

        curl_setopt($data_package, CURLOPT_URL, $url_package);
        curl_setopt($data_package, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data_package, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data_package, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data_package, CURLOPT_SSL_VERIFYPEER, 0);
        $response_datap = json_decode(curl_exec($data_package), true);
        $returnp = curl_errno($data_package); //returns 0 if no errors occured
        curl_close($data_package);

        $select_pack = array();
        $package_data = $response_datap['subscriptionpackage'];
        if (sizeof($package_data) > 0) {
            for ($i = 0; $i < sizeof($package_data); $i++) {
                if ($package_data[$i]['PackageID'] == $PackageID) {
                    $select_pack = $package_data[$i];
                    break;
                }
            }
        }
        $selected_pack = $select_pack;

        $SubscriptionAmount = $selected_pack['PackAmount'];
        $days = round($selected_pack['NoOfDays']);

        $SubFromDate = date('Y-m-d', strtotime($subscription_date));
        $SubEndDate = date('Y-m-d', strtotime('+' . $days . 'months', strtotime($SubFromDate)));


        $data = array
            (
            "SubscriptionId" => $SubscriptionId,
            "UserId" => $user_id,
            "PackageID" => $PackageID,
            "SubscriptionDate" => $subscription_date,
            "SubscriptionAmount" => $SubscriptionAmount,
            "IsSubscribed" => 'true',
            "TransactionId" => $TransactionId,
            "InvoiceId" => $InvoiceId,
            "CreatedOnMobile" => $this->input->post('CreatedOnMobile'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "IsSync" => 'false',
            "SubFromDate" => $SubFromDate,
            "SubEndDate" => $SubEndDate
        );
     
        $datajson['subscription'][0] = $data;
        $data_string = json_encode($datajson);
        $data_string = str_replace("\\/", "/", $data_string);
     // echo "<pre>"; print_r($data); exit;   
        //exit;
        $url = SYNCTODB;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response_data = curl_exec(json_decode($ch),true);
        $return = curl_errno($ch);
          
        if ($return == 0) {
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
            $emailid = $user['EmailID'];
            $subject = 'Your subscription has been updated | Demostream';

            $message = '<html><body>';
            $message .= '<b>Hello ' . $user['FirstName'] . ', <br>you are successfully subscribed for ' . $days . ' months at demostream.</b><br><br>';
            $message .= '<table>';
            $message .= '<tr><td><b>Subscription Date :</b>' . $subscription_date . '</td></tr>';
            $message .= '<tr><td><b>Package :</b>' . $select_pack['PackageName'] . '</td></tr>';
            $message .= '<tr><td><b>Package amount :</b>' . $SubscriptionAmount . '</td></tr><br>';
            $message .= '</table><br><br><br>Thank You<br>website: http://demostream.tv<br><br>';
            $message .= '</body></html>';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(FROM_MAIL, 'Demostream | website');
            $this->email->to($emailid);
            $this->email->set_mailtype("html");
            $this->email->subject($subject);
            $this->email->message($message);
           $this->email->send();
            $this->email->print_debugger();

            $this->session->set_flashdata('success', 'Subscription Updated Successfully.');
            redirect(base_url() . "admin/Clients/view_subscription");
        } else {
            $this->session->set_flashdata('danger', 'Subscription Updated Failed.');
            redirect(base_url() . "admin/Clients/view_subscription");
        }
    }

    public function view_subscription() {

        $url = Subscriptionlist;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);
        $Userdetail['Userdetail'] = $response_data['subscription'];

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_subscription', $Userdetail);
        $this->load->view('admin/includes/footer');
    }

    public function add_new_package() {

         $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
        
        if($user['NetworkKey'] != '' && $user['NetworkKey'] != 'null'){
           $network_key = $user['NetworkKey'];
        }else{
            $this->session->set_flashdata('danger', 'Please configure your network.');
            redirect(base_url() . "admin/Clients/add_package");
        }

        $package_name = $this->input->post('name');
        $price = $this->input->post('price');
        $month = $this->input->post('month');
        $size = sizeof($package_name);

        $package_product_key = '';
        for ($i = 0; $i < $size; $i++) {

            $product_key = strtolower($package_name[$i]);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => CREATE_PRODUCT_FOR_NETWORK,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN
                . "&apiPassword=" . API_PASSWORD . "&"
                . "networkKey=" . $network_key . "&"
                . "productKey=" . str_replace(' ', '', $product_key)
                . "&name=" . $package_name[$i] . "&"
                . "url=" . base_url()
                . "&type=1",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response_ning = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $this->session->set_flashdata('danger', 'Please configure your network.');
                redirect(base_url() . "admin/Clients/add_package");
                // echo "cURL Error #:" . $err;
            } else {
                $response_ning_array = json_decode($response_ning);
                if ($response_ning_array->productId != '') {
                    $package_product_key = str_replace(' ', '', $product_key);
                }
            }
            $data = array
                (
                "DealerID" => $UserID,
                "PackageID" => 0,
                "PackageName" => $package_name[$i],
                "PackAmount" => $price[$i],
                "NoOfDays" => $month[$i],
                "CreatedOnMobile" => date('Y-m-d h:i:s'),
                "CreatedOn" => date('Y-m-d h:i:s'),
                "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "IsDeleted" => "false",
                "ProductKey" => $package_product_key
            );

            $datajson['subscriptionpackage'][0] = $data;
            $data_string = json_encode($datajson);
            $data_string = str_replace("\\/", "/", $data_string);
            exit;
           // $url = SYNCTODB;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response_data = curl_exec($ch);
            $return = curl_errno($ch);
        }
        $this->session->set_flashdata('success', 'Package Added Successfully.');
        redirect(base_url() . "admin/Clients/add_package");
    }

    public function view_clients() {
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


        $Clientdetail['clients'] = $response_data['UserDetails'];
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_clients', $Clientdetail);
        $this->load->view('admin/includes/footer');
    }

    public function edit_client($user_id) {

        $url1 = Userlist;
        //$url = Userlist;
        $data1 = curl_init();
        curl_setopt($data1, CURLOPT_URL, $url1);
        curl_setopt($data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data1, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data1), true);
        $return = curl_errno($data1); //returns 0 if no errors occured
        curl_close($data1);

        $Userdetail = $response_data1['UserDetails'];

        if (sizeof($Userdetail) > 0) {
            for ($i = 0; $i < sizeof($Userdetail); $i++) {
                if ($Userdetail[$i]['UserID'] == $user_id) {
                    $edit_user['edit_user'] = $Userdetail[$i];
                    break;
                }
            }
        }
//        echo "<pre>";print_r($edit_user);exit;
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/edit_client', $edit_user);
        $this->load->view('admin/includes/footer');
    }

    public function update_client() {
        $user_id = $this->input->post('UserID');
        $url1 = Userlist;
        //$url = Userlist;
        $data1 = curl_init();
        curl_setopt($data1, CURLOPT_URL, $url1);
        curl_setopt($data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data1, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data1), true);
        $return = curl_errno($data1); //returns 0 if no errors occured
        curl_close($data1);

        $Userdetail = $response_data1['UserDetails'];

        if (sizeof($Userdetail) > 0) {
            for ($i = 0; $i < sizeof($Userdetail); $i++) {
                if ($Userdetail[$i]['UserID'] == $user_id) {
                    $edit_user = $Userdetail[$i];
                    break;
                }
            }
        }

        $uploaded = $this->Upload->do_upload('userfile');

        $file_name = '';

        if (!isset($uploaded['error'])) {
            @$Profilepic = $uploaded['upload_data']['file_name'];
        } else {
            $Profilepic = $edit_user['ProfilePICPath'];
        }


        $uploaded_logo = $this->Upload->do_upload_logo('logo');
        $logo_name = '';
        if (!isset($uploaded_logo['error'])) {
            @$logo_name = $uploaded_logo['upload_data']['file_name'];
        } else {
            $logo_name = $edit_user['Logo'];
        }

        $domain = $this->input->post('domain');
        $FirstName = $this->input->post('firstname');
        $LastName = $this->input->post('lastname');
        $emailid = $this->input->post('emailid');
        $password = $this->input->post('password');
        $city = $this->input->post('city');
        $State = $this->input->post('state');
        $Country = $this->input->post('country');
        $phone = $this->input->post('phone');
        $website = $this->input->post('website');

        $account_name = $this->input->post('account_name');
        $sub_charge = $this->input->post('sub_charge');
        $transaction_share = $this->input->post('transaction_share');
        $VideoPurchaseShare = $this->input->post('VideoPurchaseShare');
        if ($this->input->post('UserID') == 1) {
            $IsSuperAdmin = 'true';
            $IsAdmin = 'true';
        } else {
            $IsSuperAdmin = 'false';
            $IsAdmin = 'false';
        }

        $data1 = array(
            "MobileRowOrderNo" => '0',
            "ProfileID" => $this->input->post('ProfileID'),
            "UserID" => $this->input->post('UserID'),
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "Region" => 'a',
            "City" => $city,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => $Profilepic,
            "DeviceID" => $edit_user['DeviceID'],
            "CreatedOnMobile" => $edit_user['CreatedOnMobile'],
            "CreatedOn" => $edit_user['CreatedOn'],
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "AccountName" => $account_name,
            "EmailID" => $emailid,
            "Password" => $password,
            "IsSignWithSocialMedia" => 'false',
            "IsAdmin" => $IsAdmin,
            "SubscriptionCharges" => $sub_charge,
            "TransactionShare" => $transaction_share,
            "VideoPurchaseShare" => $VideoPurchaseShare,
            "Website" => $website,
            "Logo" => $logo_name,
            "Domain" => $domain,
            "MobileNo" => $phone,
            "IsSuperAdmin" => $IsSuperAdmin
        );

        $datajson1['userprofiledetails'][0] = $data1;
        $data_string1 = json_encode($datajson1);
        $data_string1 = str_replace("\\/", "/", $data_string1);
        //exit;
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
            $subject = 'Your profile has been updated | Demostream';

            $message = '<html><body>';
            $message .= '<b>Hello ' . $FirstName . ', <br><br>Please check your details by login above email id and password.</b><br><br>';
            $message .= '<table>';
            $message .= '<tr><td><b>Email :</b>' . $emailid . '</td></tr>';
            $message .= '<tr><td><b>Password :</b>' . $password . '</td></tr><br>';
            $message .= '<tr><td><b>' . $body . '</b></td><td></td></tr>';
            $message .= '</table><br><br>Thank You<br>website: http://demostream.tv<br><br>';
            $message .= '</body></html>';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(FROM_MAIL, 'Demostream | website');
            $this->email->to($emailid);
//        $this->email->bcc('jinal.panchal@innoviussoftare.com');
            $this->email->set_mailtype("html");
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
            $this->email->print_debugger();

            $this->session->set_flashdata('success', 'Client Details Updated Successfully.');
            redirect(base_url() . "admin/Clients/view_clients");
        } else {

            $this->session->set_flashdata('danger', 'Client Details Updated Failed.');
            redirect(base_url() . "admin/Clients/view_clients");
        }
    }

    public function search_subscription() {

        $search_date = $this->input->post('search_date');
        $search_date1 = $this->input->post('search_date1');
        if ($search_date != '' || $search_date1 != '') {

            $url = Subscriptionlist;
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data = json_decode(curl_exec($data), true);
            $return = curl_errno($data); //returns 0 if no errors occured
            curl_close($data);

            $detail = $response_data['subscription'];
            $html = '';
            if (sizeof($detail) > 0) {
                $html .= ' <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Subscription Date</th>
                                                <th>Subscription Amount</th>
                                                <th>Invoice Id</th>
                                                <th>From Date</th>
                                                <th>End Date</th>
                                                <th>Account Name</th>
                                                <th>Action</th>
                                                <th>Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                for ($i = 0; $i < sizeof($detail); $i++) {

                    if ($search_date != '') {
                        $dates = explode('-', $search_date);

                        $from_date = strtotime($dates[0]);
                        $end_date = strtotime($dates[1]);

                        $dates1 = explode('-', $search_date);

                        $from_date1 = strtotime($dates1[0]);
                        $end_date1 = strtotime($dates1[1]);

                        $subfrom_date = $detail[$i]['SubscriptionDate'];
                        $subfrom_date = strtotime($subfrom_date);
                        $subfrom_date1 = $detail[$i]['SubscriptionDate'];
                        $subfrom_date1 = strtotime($subfrom_date1);
                    } elseif ($search_date1 != '') {
                        $dates = explode('-', $search_date1);

                        $from_date = strtotime($dates[0]);
                        $end_date = strtotime($dates[1]);

                        $dates1 = explode('-', $search_date1);

                        $from_date1 = strtotime($dates1[0]);
                        $end_date1 = strtotime($dates1[1]);

                        $subfrom_date = $detail[$i]['SubEndDate'];
                        $subfrom_date = strtotime($subfrom_date);
                        $subfrom_date1 = $detail[$i]['SubEndDate'];
                        $subfrom_date1 = strtotime($subfrom_date1);
                    } elseif ($search_date1 != '' && $search_date != '') {
                        $dates = explode('-', $search_date);

                        $from_date = strtotime($dates[0]);
                        $end_date = strtotime($dates[1]);

                        $dates1 = explode('-', $search_date1);

                        $from_date1 = strtotime($dates1[0]);
                        $end_date1 = strtotime($dates1[1]);

                        $subfrom_date = $detail[$i]['SubscriptionDate'];
                        $subfrom_date = strtotime($subfrom_date);
                        $subfrom_date1 = $detail[$i]['SubEndDate'];
                        $subfrom_date1 = strtotime($subfrom_date1);
                    }

                    if ($subfrom_date >= $from_date && $subfrom_date <= $end_date && $subfrom_date1 >= $from_date1 && $subfrom_date1 <= $end_date1) {

                        $search_array[] = $detail[$i];

                        $name = $detail[$i]['FirstName'] . ' ' . $detail[$i]['LastName'];
                        $sub_date = date('m/d/Y', strtotime($detail[$i]['SubscriptionDate']));
                        $amount = $detail[$i]['SubscriptionAmount'];
                        $invoice_id = $detail[$i]['InvoiceId'];
                        $subscription_from_date = date('m/d/Y', strtotime($detail[$i]['SubFromDate']));
                        $subscription_end_date = date('m/d/Y', strtotime($detail[$i]['SubEndDate']));
                        $account_name = $detail[$i]['AccountName'];
                        $SubscriptionId = $detail[$i]['SubscriptionId'];
                        $email = $detail[$i]['EmailID'];
                        $html .= '<tr>
                                                    <td>' . $name . '</td>                                                    
                                                    <td>' . $sub_date . '</td>
                                                    <td>' . $amount . '</td>
                                                    <td>' . $invoice_id . '</td>                                                    
                                                    <td>' . $subscription_from_date . '</td>
                                                    <td>' . $subscription_end_date . '</td>       
                                                    <td>' . $account_name . '</td>
                                                    <td><a href="' . base_url() . 'admin/Clients/edit_view_subscription/' . $SubscriptionId . '">
                                                        <i class="fa fa-pencil-square-o">&nbsp;</i></a></td>
                                                        <td>' . $email . '</td>
                                                </tr>';
                    }
                }
                $html .= '</tbody>';
                echo $html;
            }
        } else {

            $url = Subscriptionlist;
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data = json_decode(curl_exec($data), true);
            $return = curl_errno($data); //returns 0 if no errors occured
            curl_close($data);

            $detail = $response_data['subscription'];
            $html = ' <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Subscription Date</th>
                                                <th>Subscription Amount</th>
                                                <th>Invoice Id</th>
                                                <th>From Date</th>
                                                <th>End Date</th>
                                                <th>Account Name</th>
                                                <th>Action</th>
                                                <th>Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
            for ($i = 0; $i < sizeof($detail); $i++) {
                $search_array[] = $detail[$i];

                $name = $detail[$i]['FirstName'] . ' ' . $detail[$i]['LastName'];
                $sub_date = date('m/d/Y', strtotime($detail[$i]['SubscriptionDate']));
                $amount = $detail[$i]['SubscriptionAmount'];
                $invoice_id = $detail[$i]['InvoiceId'];
                $subscription_from_date = date('m/d/Y', strtotime($detail[$i]['SubFromDate']));
                $subscription_end_date = date('m/d/Y', strtotime($detail[$i]['SubEndDate']));
                $account_name = $detail[$i]['AccountName'];
                $SubscriptionId = $detail[$i]['SubscriptionId'];
                $email = $detail[$i]['EmailID'];
                $html .= '<tr>
                                                    <td>' . $name . '</td>                                                    
                                                    <td>' . $sub_date . '</td>
                                                    <td>' . $amount . '</td>
                                                    <td>' . $invoice_id . '</td>                                                    
                                                    <td>' . $subscription_from_date . '</td>
                                                    <td>' . $subscription_end_date . '</td>       
                                                    <td>' . $account_name . '</td>
                                                    <td><a href="' . base_url() . 'admin/Clients/edit_view_subscription/' . $SubscriptionId . '">
                                                        <i class="fa fa-pencil-square-o">&nbsp;</i></a></td>
                                                        <td>' . $email . '</td>
                                                </tr>';
            }
            $html .= '</tbody>';
            echo $html;
        }
    }

}

?>
