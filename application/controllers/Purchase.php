<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('stripegateway');
    }

    public function index() {
        $videoAmount = $this->session->userdata('video_amount');
        $data['video_amount'] = $videoAmount;
        if (!empty($this->session->userdata('DOWNLOAD_USERKEY'))) {
            $this->payment_success($this->session->userdata('Video_ID'));
            $this->session->unset_userdata('DOWNLOAD_USERKEY');
        } else {

            $this->video_donate();
        }
//        $this->load->view('includes/header');
//        $this->load->view('includes/top-menu');
//        $this->load->view('pages/video_donate', $data);
//        $this->load->view('includes/footer');
    }

    public function video_donate() {
        $Video_ID = $this->session->userdata('Video_ID');
        $User_ID = $this->session->userdata('User_ID');

        $login_userdata = $this->session->userdata('login_userdata');
        $email = $login_userdata['EmailID'];
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
                if ($Userdetail[$i]['UserID'] == $User_ID) {
                    $user = $Userdetail[$i];
                    break;
                }
            }
        }
        $url1 = VIDEO_DETAIL . "?UserId=0&isHome=0&isProfile=0&Count=10000&PageNum=1&VideoID=" . $Video_ID;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response_video1 = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (sizeof($response_video1['videodetails']) > 0) {
            $ProductKey = @$response_video1['videodetails'][0]['ProductKey'];
            $NetworkKey = @$user['NetworkKey'];
           
//            $ProductKey = 'hiphop_donation';
//            $NetworkKey = 'testSite';

            $this->session->set_userdata('Network_key', $NetworkKey);
            $this->session->set_userdata('Product_key', $ProductKey);

            if ($ProductKey == '' || $NetworkKey == '') {
                $this->session->unset_userdata('download_user_id');
                $this->session->set_flashdata('danger', 'Payment method is not set.');
                redirect('Video_curl/video/' . $Video_ID);
            }
            $userKey = $email . '_' . rand(00000000, 99999999);
            $this->session->set_userdata('DOWNLOAD_USERKEY', $userKey);
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
                . "successGoBackUrl%5D=" . base_url() . '/payment_success/' . $Video_ID,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
//                        echo "cURL Error #:" . $err;
                $this->session->set_flashdata('danger', 'Payment method is not set.');
                redirect('Video_curl/video/' . $Video_ID);
            } else {
                $payment_url = (array) json_decode($response);
                $urlll = $payment_url['paymentPageUrl'];
                redirect($urlll);
            }
        } else {
            $this->session->set_flashdata('danger', 'Payment method is not set.');
            redirect('Video_curl/video/' . $Video_ID);
        }
    }

    public function payment_success($video_id) {

        $USER_KEY = $this->session->userdata('DOWNLOAD_USERKEY');
        $ProductKey = $this->session->userdata('Product_key');
        $NetworkKey = $this->session->userdata('Network_key');

//        $ProductKey = 'hiphop_donation';
//        $NetworkKey = 'testSite';

        if ($ProductKey == '' || $NetworkKey == '') {
            $this->session->unset_userdata('DOWNLOAD_USERKEY');
            $this->session->unset_userdata('Network_key');
            $this->session->unset_userdata('Product_key');
            $this->session->set_flashdata('danger', 'Something went wrong.');
            redirect('Video_curl/video/' . $video_id);
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => CHECK_USER_PERMISSION,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . "&"
            . "apiPassword=" . API_PASSWORD . "&"
            . "productKey=" . $ProductKey . "&"
            . "networkKey=" . $NetworkKey . "&"
            . "userKey=" . $USER_KEY,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
//                echo "cURL Error #:" . $err;
            $this->session->unset_userdata('DOWNLOAD_USERKEY');
            $this->session->unset_userdata('Network_key');
            $this->session->unset_userdata('Product_key');
            $this->session->set_flashdata('danger', 'Something went wrong.');
            redirect('Video_curl/video/' . $video_id);
        } else {
            $success_array = (array) json_decode($response);
        }
        if ($success_array['hasPermission'] != 0) {

            $date = date('Y-m-d');
            $day_before = date('Y-m-d', strtotime($date . ' -1 day'));
            $from_date = new DateTime($day_before . '00:00:01');
            $to_date = new DateTime(date('Y-m-d') . '24:00:00');
            $from_date_unix = $from_date->format("U");
            $to_date_unix = $to_date->format("U");

            $curl1 = curl_init();

            curl_setopt_array($curl1, array(
                CURLOPT_URL => GET_PAYMENT_HISTORY,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . ""
                . "&apiPassword=" . API_PASSWORD . ""
                . "&networkKey=" . $NetworkKey . ""
                . "&from=" . $from_date_unix . ""
                . "&to=" . $to_date_unix,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response1 = curl_exec($curl1);
            $err1 = curl_error($curl1);

            curl_close($curl1);

            if ($err1) {
//                    echo "cURL Error #:" . $err1;
                $this->session->unset_userdata('Network_key');
                $this->session->unset_userdata('Product_key');
                $this->session->unset_userdata('DOWNLOAD_USERKEY');
                $this->session->set_flashdata('danger', 'Payment Failed.');
                redirect('Video_curl/video/' . $video_id);
            } else {
                $user_key_as_transaction_id = '0';
                $data_array = json_decode($response1);
                foreach ($data_array as $payment_history) {
                    if ($payment_history->userKey == $USER_KEY) {
                        $payment_data = $payment_history;
                    }
                }
                $user_key_as_transaction_id = $payment_data->userKey;
                $login_userdata = $this->session->userdata('login_userdata');
                $user_id = 0;
                $user_id = @$login_userdata['UserID'];

                $PurchaseOn = date('Y-m-d h:i:s');
                $video_purchase = array(
                    'PurchaseId' => 0,
                    'VideoId' => $video_id,
                    'UserId' => $user_id,
                    'PurchaseOn' => $PurchaseOn,
                    'TranscationNo' => $user_key_as_transaction_id
                );
                $datajson['videopurchase'][0] = $video_purchase;
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
                curl_close($ch);
                $this->session->unset_userdata('Network_key');
                $this->session->unset_userdata('Product_key');
                $this->session->unset_userdata('DOWNLOAD_USERKEY');
                if ($return == 0) {
                    $this->session->set_flashdata('success', 'Payment Successfully.');
                    redirect('Video_curl/video/' . $video_id);
                } else {
                    $this->session->set_flashdata('danger', 'Payment Failed.');
                    redirect('Video_curl/video/' . $video_id);
                }
            }
        } else {
            $this->session->unset_userdata('DOWNLOAD_USERKEY');
            $this->session->unset_userdata('Network_key');
            $this->session->unset_userdata('Product_key');
            $this->session->set_flashdata('danger', 'Payment Failed.');
            redirect('Video_curl/video/' . $video_id);
        }
    }

    public function payment_donation() {

        if (isset($_POST['payment-stripe'])) {
            if ($this->session->userdata('video_amount')) {
                $videoAmount = $this->session->userdata('video_amount');
                $data_cards = array(
                    'number' => $this->input->post('cardnumber'),
                    'exp_month' => $this->input->post('expirymonth'),
                    'exp_year' => $this->input->post('expiryyear'),
                    'amount' => $videoAmount,
                    'cvc' => $this->input->post('cvc')
                );
                $uid = $this->session->userdata('getuser'); // payment user
                $iscampaign = $this->session->userdata('iscampaign');
                $Video_ID = $this->session->userdata('Video_ID');
                //print_r($data_cards);
                $login_userdata = $this->session->userdata('login_userdata');
                $Login_userID = $login_userdata['UserID'];


                $url_donate = FUND_MANAGER . "?UserID=" . $uid . "&Count=5&PageNum=1";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url_donate);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response_data_donate = json_decode(curl_exec($ch), true);
                curl_close($ch);

                // print_r($response_data_donate);

                $secret_key = $response_data_donate['fundmanager'][0]['PayPalClientID'];
                if ($secret_key != '') {
                    $keys = explode("demostream", $secret_key);
                    $stripe = array("public_key" => $keys[0],
                        "secret_key" => $keys[1]);
                    // print_r($data_cards);
                    $charge = $this->stripegateway->checkout($data_cards, $stripe);
                    // exit;
                    if ($charge != '' && $charge != 1) {

                        $transactionId = $charge->id;
                        $PurchaseOn = date('Y-m-d h:i:s');
                        $video_purchase = array('VideoId' => $Video_ID,
                            'UserId' => $Login_userID,
                            'PurchaseOn' => $PurchaseOn,
                            'IsCampaign' => $iscampaign,
                            'TranscationNo' => $transactionId
                        );
                        $datajson['videopurchase'][0] = $video_purchase;
                        $data_string = json_encode($datajson);
                        // print_r($video_purchase);exit;

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
                        curl_close($ch);

                        $message = $charge->status;
                        $msg['data_msg'] = $charge->status;
                        $this->session->set_flashdata('data_msg', $message);

                        if ($iscampaign == 1) {
                            redirect('Video_curl/campaign/' . $Video_ID);
                        } else {
                            redirect('Video_curl/video/' . $Video_ID);
                        }
                    } else {
                        $message = "Owner is denied make a payment";
                        $this->session->set_flashdata('data_msg', $message);
                        redirect('Video_curl/video/' . $Video_ID);
                    }
                }
            }
        }
    }

}

?>