<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        // $this->load->library('stripegateway');	
    }

    public function store_donate() {
        $donation = $this->input->post('donation');
        if ($donation == 'INVOICE DONATION') {
            // $amount=$this->input->post('amount');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            $stripe = $this->input->post('stripe-true');
            $offers = $this->input->post('offers-true');
            $donor_true = $this->input->post('donor-true');
            $Video_ID = $this->input->post('video_id');
            $user_id = $this->input->post('user_id');

            $donation_data = array('email' => $email,
                'mobile' => $mobile,
                'stripe' => $stripe,
                'offers' => $offers,
                'donor_type' => $donor_true);

            $donation = $this->session->set_userdata('Donation_data', $donation_data);

            $url = USER_AUTHEDICATE . "?Un=j@giftedkulture.com&Pwd=demo";
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data = json_decode(curl_exec($data), true);
            curl_close($data);

            $size = sizeof($response_data['userprofiledetails']);
            /* Curl Complete */
            if ($size != 0) {
                $owner_data = $this->session->set_userdata('Owner_data', $response_data['userprofiledetails'][0]);
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

                $Userdetail = $response_data1['UserDetails'];
                $User_donate = array();
                if (sizeof($Userdetail) > 0) {
                    for ($i = 0; $i < sizeof($Userdetail); $i++) {
                        if ($Userdetail[$i]['UserID'] == $user_id) {
                            $User_donate = $Userdetail[$i];
                            break;
                        }
                    }
                }
                if (sizeof($User_donate) > 0 && $User_donate['ProductKey'] != '' && $User_donate['NetworkKey'] != '') {

                    $userKey = $email . '_' . rand(00000000, 99999999);
                    $this->session->set_userdata('DONATE_USER_KEY', $userKey);
                    $this->session->set_userdata('DONATE_VIDEO_ID', $Video_ID);

                    $ProductKey = @$User_donate['ProductKey'];
                    $NetworkKey = @$User_donate['NetworkKey'];

//                    $NetworkKey = 'testSite';
//                    $ProductKey = 'hiphop_donation';

                    if ($ProductKey == '' || $NetworkKey == '') {
                        $this->session->unset_userdata('DONATE_USER_KEY');
                        $this->session->unset_userdata('DONATE_VIDEO_ID');
                        $this->session->set_flashdata('danger', 'Payment method is not set.');
                        redirect('Video_curl/video/' . $Video_ID);
                    }

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => REGISTER_PAYMENT_DATA,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . "&"
                        . "apiPassword=" . API_PASSWORD . "&"
                        . "networkKey=" . $NetworkKey . "&"
                        . "data%5BproductKey%5D=" . $ProductKey . "&"
                        . "data%5BuserKey%5D=" . $userKey . "&"
                        . "data%5Bemail%5D=" . $email . "&"
                        . "successGoBackUrl%5D=" . SUCCESS_GOBACK_URL_DONATE,
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded"
                        ),
                    ));

                    $response_ning = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        $message = "Owner not found";
                        $this->session->set_flashdata('data_msg', $message);
                        redirect('Video_curl/video/' . $Video_ID);
                    } else {
                        // echo $response_ning;exit;
                        $donate_url = (array) json_decode($response_ning);
                        $donation_urls = $donate_url['paymentPageUrl'];
                        redirect($donation_urls);
                    }
                } else {
                    $message = "Owner not found";
                    $this->session->set_flashdata('data_msg', $message);
                    redirect('Video_curl/video/' . $Video_ID);
                }
            } else {
                $message = "Owner not found";
                $this->session->set_flashdata('data_msg', $message);
                redirect('Video_curl/video/' . $Video_ID);
            }
        }
    }

    public function complete_donation() {
        if (!empty($this->session->userdata('DONATE_USER_KEY')) && !empty($this->session->userdata('DONATE_VIDEO_ID'))) {
            $USER_KEY = $this->session->userdata('DONATE_USER_KEY');
            $Video_Id = $this->session->userdata('DONATE_VIDEO_ID');

            $date = date('Y-m-d');
            $day_before = date('Y-m-d', strtotime($date . ' -1 day'));
            $from_date = new DateTime($day_before . '00:00:01');
            $to_date = new DateTime(date('Y-m-d') . '24:00:00');
            $from_date_unix = $from_date->format("U");
            $to_date_unix = $to_date->format("U");

            $url = VIDEO_DETAIL . "?UserId=0&isHome=0&isProfile=0&Count=100&PageNum=1&VideoID=" . $Video_Id;
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_video1 = json_decode(curl_exec($data), true);
            curl_close($data);
            if (sizeof($response_video1['videodetails']) > 0) {

                $videodetails = $response_video1['videodetails'];

                $network_key = @$videodetails[0]['NetworkKey'];
//                $network_key = 'testSite';
                if ($network_key != '' && $network_key != 'null') {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => GET_PAYMENT_HISTORY,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . ""
                        . "&apiPassword=" . API_PASSWORD . ""
                        . "&networkKey=" . $network_key . ""
                        . "&from=" . $from_date_unix . ""
                        . "&to=" . $to_date_unix,
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded"
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        echo "cURL Error #:" . $err;
                        exit;
                    } else {
                        $data_array = json_decode($response);
                        foreach ($data_array as $payment_history) {
                            if ($payment_history->userKey == $USER_KEY) {
                                $payment_data = $payment_history;
                            }
                        }
                        $donation_data = $this->session->userdata('Donation_data');
                        $Owner_data = $this->session->userdata('Owner_data');
                        $creadtedonmobile = date('Y-m-d h:i:s');
                        $sync = 'false';
                        $deviceId = '0';
                        if ($payment_data->invoices[0]->invoiceChargedAmount != '' && $payment_data->invoices[0]->invoiceChargedAmount != 0) {
                            $amount_store = $payment_data->invoices[0]->invoiceChargedAmount / 100;

                            $user = $this->session->userdata('login_userdata');
                            $LoginUserID = $user['UserID'];

                            $donate_complete = array();
                            $donate_complete['DonationDetID'] = 0;
                            $donate_complete['CampaignDetID'] = $donation_data['video_id'];
                            $donate_complete['CreatedOn'] = $creadtedonmobile;
                            $donate_complete['CreatedOnMobile'] = $creadtedonmobile;
                            $donate_complete['DeviceID'] = $deviceId;
                            $donate_complete['DonatedBy'] = $LoginUserID;
                            $donate_complete['DonatedOn'] = $creadtedonmobile;
                            $donate_complete['DonationAmount'] = $amount_store;
                            $donate_complete['DonationDetId'] = $DonateId;
                            $donate_complete['InvoiceID'] = 0;
                            $donate_complete['IsAcceptsOffers'] = $donation_data['offers'];
                            $donate_complete['IsAnonymous'] = $donation_data['donor_type'];
                            $donate_complete['IsCampaign'] = 'true';
                            $donate_complete['IsSync'] = $sync;
                            $donate_complete['PPUserName'] = '';
                            $donate_complete['PaymentType'] = 'epayment';
                            $donate_complete['TransactionNo'] = $transactionId;
                            $donate_complete['UpdatedOn'] = $creadtedonmobile;
                            $donate_complete['UpdatedOnMobile'] = $creadtedonmobile;
                            $donate_complete['UserID'] = $donation_data['user_id'];


                            $datajson['donationdetails'][0] = $donate_complete;
                            $data_string = json_encode($datajson);

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
                            $message = 'Donation added successfully.';
                            $this->session->set_flashdata('success', $message);
                            $this->session->unset_userdata('DONATE_USER_KEY');
                            $this->session->unset_userdata('DONATE_VIDEO_ID');
                            redirect('Video_curl/video/' . $Video_Id);
                        }
                    }
                }
            }
        }
        redirect('Video_curl/video/' . $Video_Id);
    }

    public function payment_donation() {
        $Video_ID = $this->session->userdata['Video_ID'];
        $iscampaign = $this->session->userdata['iscampaign'];
        //echo '<pre>';	 
        $donation_data = $this->session->userdata('Donation_data');
        $Owner_data = $this->session->userdata['Owner_data'];
        $campaign_details = $this->session->userdata['campaign_details'];

        if ($iscampaign == 1) {
            $CampaignOwnerID = $campaign_details['CampaignOwnerID'];
        } else {
            $CampaignOwnerID = $campaign_details['UserID'];
        }

        //print_r($donation_data);
        //print_r($Owner_data);

        $amount_store = $donation_data['amount'];

        if ($CampaignOwnerID == 1) {
            $transactionShare = $amount_store * 100;
        } else {
            $transactionShare = $Owner_data['TransactionShare'] * 100;
        }

        $data_r["message"] = "";
        if (isset($_POST['payment-stripe'])) {
            $data_cards = array(
                'number' => base64_encode($this->input->post('cardnumber')),
                'exp_month' => $this->input->post('expirymonth'),
                'exp_year' => $this->input->post('expiryyear'),
                'amount' => $transactionShare,
                'cvc' => base64_encode($this->input->post('cvc'))
            );

            $transactionDonate = $this->input->post('amount') - $transactionShare;
            $data_cards_donate = array(
                'number' => base64_encode($this->input->post('cardnumber')),
                'exp_month' => $this->input->post('expirymonth'),
                'exp_year' => $this->input->post('expiryyear'),
                'amount' => $transactionDonate * 100,
                'cvc' => base64_encode($this->input->post('cvc'))
            );

            /*             * *********************TransactionShare For Jack Knight********************************************* */
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

            /*             * *********************************TransactionShare For Particular User******************************* */

            $url_donate = FUND_MANAGER . "?UserID=" . $CampaignOwnerID . "&Count=5&PageNum=1";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_donate);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data_donate = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $secret_key_donate = $response_data_donate['fundmanager'][0]['PayPalClientID'];


            if ($secret_key != '' && $secret_key_donate != '') {
                $keys1 = explode("demostream", $secret_key);
                $keys2 = explode("demostream", $secret_key_donate);

                //$keys1 = array("pk_test_GF0y48SCqViKdCSA8LwOPFVj","sk_test_SWtrR1X9Tax5G9V4wlCtjoVy"); //jack knight API
                //$keys2=array("pk_test_GF0y48SCqViKdCSA8LwOPFVj","sk_test_SWtrR1X9Tax5G9V4wlCtjoVy"); //Particular User API
                $stripe1 = array("public_key" => $keys1[0],
                    "secret_key" => $keys1[1]);

                $stripe2 = array("public_key" => $keys2[0],
                    "secret_key" => $keys2[1]);

                $charge = $this->stripegateway->checkout($data_cards, $stripe1);
                if ($charge != '1') {
                    $charge1 = $charge;
                }
                if ($CampaignOwnerID != 1) {
                    $charge1 = $this->stripegateway->checkout($data_cards_donate, $stripe2);
                }



                if ($charge != '1' && $charge1 != '1') {
                    $transactionId = $charge;
                    // echo '<pre>';				print_r($charge);exit;

                    $creadtedonmobile = date('Y-m-d h:i:s');
                    $DonateId = round(microtime(true));
                    $sync = 'false';
                    $deviceId = '9a889cf4060900d';
                    $donate = array('CampaignDetID' => $Video_ID,
                        'CreatedOn' => $creadtedonmobile,
                        'CreatedOnMobile' => $creadtedonmobile,
                        'DeviceID' => $deviceId,
                        'DonatedBy' => $campaign_details['UserID'],
                        'DonatedOn' => $creadtedonmobile,
                        'DonationAmount' => $amount_store,
                        'DonationDetId' => $DonateId,
                        'InvoiceID' => $DonateId,
                        'IsAcceptsOffers' => $donation_data['offers'],
                        'IsAnonymous' => $donation_data['donor_type'],
                        'IsCampaign' => 'true',
                        'IsSync' => $sync,
                        'PPUserName' => '',
                        'PaymentType' => 'epayment',
                        'TransactionNo' => $transactionId,
                        'UpdatedOn' => $creadtedonmobile,
                        'UpdatedOnMobile' => $creadtedonmobile,
                        'UserID' => $campaign_details['UserID']
                    );
                    $datajson['donationdetails'][0] = $donate;
                    $data_string = json_encode($datajson);

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
                    //print_r($response_data);
                    $message = 'Donation added successfully';
//echo '<pre>';				print_r($charge->status);exit;
                    $msg['data_msg'] = $charge;
                    $this->session->set_flashdata('data_msg', $message);

                    //$this->load->view('pages/view_stripe',$msg);
                    if ($iscampaign == 1) {
                        redirect('Video_curl/campaign/' . $Video_ID);
                    } else {
                        redirect('Video_curl/video/' . $Video_ID);
                    }
                } else {
                    $message = "Invalid Card Details";
                    $this->session->set_flashdata('data_msg', $message);
                    redirect('Video_curl/video/' . $Video_ID);
                }
            } else {
                $message = "Owner has denied access for payment";
                $this->session->set_flashdata('data_msg', $message);
                redirect('Video_curl/video/' . $Video_ID);
            }
        }
    }

}

?>