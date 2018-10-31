<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('stripegateway');
    }

    public function view_activities() {

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
         $url = VIDEO . "?UserId=" . $UserID . "&isHome=0&isProfile=0&Count=10000&PageNum=1";
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $video_detail['video_detail'] = $response_data['videodetails'];

        $url = FUND_MANAGER . "?UserID=" . $UserID . "&Count=10&PageNum=1";
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        if ($response_data1['fundmanager'][0]['UserID'] != 1) {
            @$video_detail['fundmanager'] = $response_data1['fundmanager'][0];
        } else {
            @$video_detail['fundmanager'] = array();
        }

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_activities', $video_detail);
        $this->load->view('admin/includes/footer');
    }

    public function select_one_video() {

        $video_id = $this->input->post('video_id');

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
        $url = DONORS . "?VideoID=" . $video_id . "&CampaignDetID=0&Count=10&PageNum=1";
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data);
        curl_close($data);
        $count = sizeof($response_data['donationdetails']);

        $html = '';
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {

                if ($response_data['donationdetails'][$i]['ProfilePICPath'] == '') {
                    $file = base_url() . 'assets/images/unknown.jpg';
                } else {

                    $file = $response_data['donationdetails'][$i]['ProfilePICPath'];
                }

                $donate_date = $response_data['donationdetails'][$i]['DonatedOn'];
                $donate_date = date('Y-m-d', strtotime($donate_date));
                $current_date = date('Y-m-d');

                $date1 = date_create($donate_date);
                $date2 = date_create($current_date);
                $diff = date_diff($date1, $date2);
                $year = $diff->format("%y");
                $month = $diff->format("%m");

                if ($year > 0) {
                    $d = $diff->format("%y year %m month %d days");
                } elseif ($month > 0) {
                    $d = $diff->format("%m Month %d days");
                } else {
                    $d = $diff->format("%d days");
                }
                $html .= '<li class="list-group-item justify-content-between" style="margin-bottom: inherit;">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-offset-1 col-md-2 thumbnail">
                                                    <img class="img-responsive" style="" src="' . $file . '"/>										
                                                </div>
                                                <div class="col-md-9 col-xs-12">
                                                    <h5>' . $response_data['donationdetails'][$i]['PPUserName'] . '</h5>
                                                    <p>$ ' . $response_data['donationdetails'][$i]['DonationAmount'] . '</p>
                                                    <p style="float: right;font-size:14px;">' . $d . '</p>
                                                </div>
                                            </div>
                                        </li>';
            }

            echo $html;
        } else {
            echo $html .= '<label>No donors as of yet.</label>';
        }
    }

    public function no_activities() {

        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];
        $url = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data = curl_init();


        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $package['subscriptionpackage'] = $response_data['subscriptionpackage'];
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/no_activities', $package);
        $this->load->view('admin/includes/footer');
    }

    public function view_payment() {

        $package['package_name'] = $this->input->post('package');
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_payment', $package);
        $this->load->view('admin/includes/footer');
    }

    public function fund() {

        $FundManagerID = $this->input->post('FundManagerID');
        $CampaignDetID = $this->input->post('CampaignDetID');
        $PaypalFirstName = $this->input->post('PaypalFirstName');
        $PaypalSecondName = $this->input->post('PaypalSecondName');
        $IsVerified = $this->input->post('IsVerified');
        $CreatedLat = $this->input->post('CreatedLat');
        $CreatedLang = $this->input->post('CreatedLang');
        $UpdatedLat = $this->input->post('UpdatedLat');
        $UpdatedLang = $this->input->post('UpdatedLang');
        $UserID = $this->input->post('UserID');
        $Subscriptioncharge = $this->input->post('Subscriptioncharge');
        $ShopifyAPIKey = $this->input->post('ShopifyAPIKey');
        $ShopifyChannelID = $this->input->post('ShopifyChannelID');
        $ShopifyStoreName = $this->input->post('ShopifyStoreName');
        $APIKeyToken = $this->input->post('APIKeyToken');
        $APIKeyPassword = $this->input->post('APIKeyPassword');
        $DropBoxApiKey = $this->input->post('DropBoxApiKey');
        $DropBoxApiSecret = $this->input->post('DropBoxApiSecret');
        $creadtedonmobile = date('Y-m-d h:i:s');
        $CreatedOn = date('Y-m-d h:i:s');

        $pk = $this->input->post('pk');
        $sk = $this->input->post('sk');
        $PaypalEmail = $this->input->post('PaypalEmail');

        $PayPalClientID = $pk . 'demostream' . $sk;


        if ($UserID == '') {
            $user = $this->session->userdata('login_userdata');
            $UserID = $user['UserID'];
        }
        if ($FundManagerID == '') {
            $FundManagerID = round(microtime(true));
        }
        if ($CampaignDetID == '') {
            $CampaignDetID = 0;
        }if ($ShopifyChannelID == '') {
            $ShopifyChannelID = round(microtime(true));
        }if ($Subscriptioncharge == '') {
            $Subscriptioncharge = '0';
        }
        $data = array
            (
            "CampaignDetID" => $CampaignDetID,
            "CreatedLang" => '',
            "CreatedLat" => $CreatedLat,
            "CreatedOn" => $CreatedOn,
            "CreatedOnMobile" => $creadtedonmobile,
            "FundManagerID" => $FundManagerID,
            "IsSync" => "false",
            "IsVerified" => "true",
            "PayPalClientID" => $PayPalClientID,
            "PaypalEmail" => $PaypalEmail,
            "PaypalFirstName" => $PaypalFirstName,
            "ShopifyAPIKey" => $ShopifyAPIKey,
            "ShopifyChannelID" => $ShopifyChannelID,
            "ShopifyStoreName" => $ShopifyStoreName,
            "Subscriptioncharge" => $Subscriptioncharge,
            "UpdatedLang" => $UpdatedLang,
            "UpdatedLat" => $UpdatedLat,
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UserID" => $UserID,
            "clientID" => $PayPalClientID,
            "APIKeyPassword" => $APIKeyPassword,
            "APIKeyToken" => $APIKeyToken
        );


        $datajson['fundmanager'][0] = $data;
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
            $this->session->set_flashdata('success', 'Fund management added successfully.');
            redirect(base_url() . "admin/Activities/view_activities");
        } else {
            $this->session->set_flashdata('danger', 'Fund management added failed.');
            redirect(base_url() . "admin/Activities/view_activities");
        }

        curl_close($ch);
    }

    public function product() {

        $FundManagerID = $this->input->post('FundManagerID');
        $APIKeyToken = $this->input->post('APIKeyToken');
        $APIKeyPassword = $this->input->post('APIKeyPassword');
        $CampaignDetID = $this->input->post('CampaignDetID');
        $PaypalFirstName = $this->input->post('PaypalFirstName');
        $PaypalEmail = $this->input->post('PaypalEmail');
        $IsVerified = $this->input->post('IsVerified');
        $CreatedLat = $this->input->post('CreatedLat');
        $CreatedLang = $this->input->post('CreatedLang');
        $UpdatedLat = $this->input->post('UpdatedLat');
        $UpdatedLang = $this->input->post('UpdatedLang');
        $UserID = $this->input->post('UserID');
        $Subscriptioncharge = $this->input->post('Subscriptioncharge');
        $ShopifyAPIKey = $this->input->post('ShopifyAPIKey');
        $ShopifyChannelID = $this->input->post('ShopifyChannelID');
        $ShopifyStoreName = $this->input->post('ShopifyStoreName');
        $APIKeyToken = $this->input->post('APIKeyToken');
        $APIKeyPassword = $this->input->post('APIKeyPassword');
        $DropBoxApiKey = $this->input->post('DropBoxApiKey');
        $DropBoxApiSecret = $this->input->post('DropBoxApiSecret');
        $creadtedonmobile = date('Y-m-d h:i:s');
        $CreatedOn = date('Y-m-d h:i:s');
        $PayPalClientID = $this->input->post('PayPalClientID');
        if ($UserID == '') {
            $user = $this->session->userdata('login_userdata');
            $UserID = $user['UserID'];
        }
        if ($FundManagerID == '') {
            $FundManagerID = round(microtime(true));
        }
        if ($CampaignDetID == '') {
            $CampaignDetID = 0;
        }
        if ($ShopifyChannelID == '') {
            $ShopifyChannelID = round(microtime(true));
        }if ($Subscriptioncharge == '') {
            $Subscriptioncharge = '0';
        }
        $data = array
            (
            "APIKeyPassword" => $APIKeyPassword,
            "APIKeyToken" => $APIKeyToken,
            "CampaignDetID" => $CampaignDetID,
            "CreatedLang" => '',
            "CreatedLat" => $CreatedLat,
            "CreatedOn" => $CreatedOn,
            "CreatedOnMobile" => $creadtedonmobile,
            "FundManagerID" => $FundManagerID,
            "IsSync" => "false",
            "IsVerified" => "true",
            "PaypalEmail" => $PaypalEmail,
            "PaypalFirstName" => $PaypalFirstName,
            "ShopifyAPIKey" => $ShopifyAPIKey,
            "ShopifyChannelID" => $ShopifyChannelID,
            "ShopifyStoreName" => $ShopifyStoreName,
            "Subscriptioncharge" => $Subscriptioncharge,
            "UpdatedLang" => $UpdatedLang,
            "UpdatedLat" => $UpdatedLat,
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UserID" => $UserID,
            "clientID" => $PayPalClientID,
            "PayPalClientID" => $PayPalClientID
        );

        $datajson['fundmanager'][0] = $data;
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
            $this->session->set_flashdata('success', 'Product management added successfully.');
            redirect(base_url() . "admin/Activities/view_activities");
        } else {
            $this->session->set_flashdata('danger', 'Product management added successfully.');
            redirect(base_url() . "admin/Activities/view_activities");
        }
        curl_close($ch);
    }

  public function payment_donation() {

        $package = $this->input->post('package');

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
                if ($package_data[$i]['PackageID'] == $package) {
                    $select_pack = $package_data[$i];
                }
            }
        }
        $selected_pack = $select_pack;

        $url1 = USER_AUTHEDICATE . "?Un=j@giftedkulture.com&Pwd=demo";
        $data1 = curl_init();
        curl_setopt($data1, CURLOPT_URL, $url1);
        curl_setopt($data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data1, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data1), true);
        curl_close($data1);

        if ($selected_pack['PackAmount'] != '') {
            $amount = $selected_pack['PackAmount'];
        } else {
            $amount = $response_data1['userprofiledetails'][0]['SubscriptionCharges'];
        }

        if (isset($_POST['submit'])) {
            $data_cards = array(
                'number' => base64_encode($this->input->post('cardnumber')),
                'exp_month' => $this->input->post('expirymonth'),
                'exp_year' => $this->input->post('expiryyear'),
                'amount' => $amount * 100,
                'cvc' => base64_encode($this->input->post('cvc'))
            );

            $url = FUND_MANAGER . "?UserID=1&Count=5&PageNum=1";
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data = json_decode(curl_exec($data), true);
            curl_close($data);

            $secret_key = $response_data['fundmanager'][0]['PayPalClientID'];

            if ($secret_key != '') {
                $keys1 = explode("demostream", $secret_key);

                $keys1 = array("public_key" => "pk_test_GF0y48SCqViKdCSA8LwOPFVj", "secret_key" => "sk_test_BXg8CAB9wtNTm1lNBe3HMK2X"); //Testing

                $charge = $this->stripegateway->admin_checkout($data_cards, $keys1);
                if ($charge != '1') {
                    $SubscriptionAmount = $amount;
                    $TransactionId = $charge;
                    $user = $this->session->userdata('login_userdata');
                    $UserID = $user['UserID'];
                    $days = round($selected_pack['NoOfDays']);
                    $InvoiceId = 0;
                    $subFromDate = date('Y-m-d');
                    $subEndDate = date('Y-m-d', strtotime('+' . $days . 'months', strtotime($subFromDate)));
                    $subscription_date = date('Y-m-d');
                    $PackageID = $selected_pack['PackageID'];

                    $data = array
                        (
                        "SubscriptionId" => 0,
                        "UserId" => $UserID,
                        "PackageID" => $PackageID,
                        "SubscriptionDate" => $subscription_date,
                        "SubscriptionAmount" => $SubscriptionAmount,
                        "IsSubscribed" => 'true',
                        "TransactionId" => $TransactionId,
                        "InvoiceId" => $InvoiceId,
                        "CreatedOnMobile" => date('Y-m-d h:i:s'),
                        "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                        "IsSync" => 'false',
                        "SubFromDate" => $subFromDate,
                        "SubEndDate" => $subEndDate
                    );

                    $datajson['subscription'][0] = $data;
                    $data_string = json_encode($datajson);
                    $data_string = str_replace("\\/", "/", $data_string);
                  $url_post = SYNCTODB;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url_post);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response_data = curl_exec($ch);
                    $return = curl_errno($ch);
                    if (sizeof(json_decode($response_data)) > 0) {
                        $username = $this->session->userdata('admin_username');
                        $password = $this->session->userdata('admin_password');

                        $urls = USER_AUTHEDICATE . "?Un=" . $username . "&Pwd=" . $password;
                        $datas = curl_init();
                        curl_setopt($datas, CURLOPT_URL, $urls);
                        curl_setopt($datas, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($datas, CURLOPT_PROXYPORT, 3128);
                        curl_setopt($datas, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($datas, CURLOPT_SSL_VERIFYPEER, 0);
                        $response_datas = json_decode(curl_exec($datas), true);
                        $returns = curl_errno($datas); //returns 0 if no errors occured
                        curl_close($datas);

                        if (sizeof($response_datas['userprofiledetails']) != 0) {

                            if (sizeof($response_datas['subscription']) != 0) {

                                $this->session->set_userdata('subscription', $response_datas['subscription']);
                                $this->session->set_userdata('subscription_admin', $response_datas['subscription']);
                            }
                        }
                        $message = "Subscribed successfully";
                        $this->session->set_flashdata('success', $message);
                        redirect(base_url() . "admin/Pages/home");
                    } else {
                        $message = "Subscribed failed";
                        $this->session->set_flashdata('danger', $message);
                        redirect(base_url() . "admin/Pages/home");
                    }
                }
            } else {
                $message = "Owner is denied make a payment";
                $this->session->set_flashdata('danger', $message);
                redirect(base_url() . "admin/Pages/home");
            }
        }
    }
    public function view_packages() {

        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];
         $url = PACKGE_LIST . '?DealerID=' . $dealer_id;
//                  $url = PACKGE_LIST . '?DealerID=1';
        $data = curl_init();

        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);
//print_r($response_data);exit;
        $package['package'] = $response_data['subscriptionpackage'];

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_package', $package);
        $this->load->view('admin/includes/footer');
    }

    public function edit_package($id) {

        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];
        $url = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data = curl_init();

        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $package = $response_data['subscriptionpackage'];

        if (sizeof($package) > 0) {
            for ($r = 0; $r < sizeof($package); $r++) {

                if ($package[$r]['PackageID'] == $id) {
                    $data_pack['edit_package'] = $package[$r];
//                    print_r($data_pack);exit;
                    break;
                }
            }
        }

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/edit_package', $data_pack);
        $this->load->view('admin/includes/footer');
    }

    public function update_package() {

        $data = array
            (
            "DealerID" => $this->input->post('DealerID'),
            "PackageID" => $this->input->post('PackageID'),
            "PackageName" => $this->input->post('PackageName'),
            "PackAmount" => $this->input->post('PackAmount'),
            "NoOfDays" => $this->input->post('NoOfDays'),
            "CreatedOnMobile" => $this->input->post('CreatedOnMobile'),
            "IsDeleted" => "false"
        );


        $datajson['subscriptionpackage'][0] = $data;
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

        $this->session->set_flashdata('success', 'Package updated successfully.');
        redirect(base_url() . "admin/Activities/view_packages");
    }

    public function delete_package($id) {


        $dealer = $this->session->userdata('dealer_data');
        $dealer_id = $dealer['UserID'];

        $url = PACKGE_LIST . '?DealerID=' . $dealer_id;
        $data = curl_init();

        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $package = $response_data['subscriptionpackage'];
        //echo '<pre>';print_r($package);

        for ($z = 0; $z < sizeof($package); $z ++) {
            if ($package[$z]['PackageID'] == $id) {
                $single_package = $package[$z];
                break;
            }
        }


        //echo "<pre>";print_r($single_package);

        $data = array
            (
            "DealerID" => $single_package['DealerID'],
            "PackageID" => $id,
            "PackageName" => $single_package['PackageName'],
            "PackAmount" => $single_package['PackAmount'],
            "NoOfDays" => $single_package['NoOfDays'],
            "CreatedOnMobile" => $single_package['CreatedOnMobile'],
            "IsDeleted" => "true"
        );

        //echo "<pre>";print_r($data);exit;

        $datajson['subscriptionpackage'][0] = $data;
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

        $this->session->set_flashdata('success', 'Package Delete successfully.');
        redirect(base_url() . "admin/Activities/view_packages");
    }

}

?>
