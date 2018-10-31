<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

    public $response = array(
        'error_code' => 1,
        'message' => "",
        'data' => array(),
    );

    public function __construct() {
        parent::__construct();
        $this->load->helper('share');
        $this->load->helper('url');
        $this->load->model('getapi');
    }

    public function get_payment_url($video_id, $u_id) {

        $login_userdata = $this->session->userdata('login_userdata');
        $email_id = '';
        if ($login_userdata['EmailID'] != '') {
            $email_id = $login_userdata['EmailID'];
        }
        $user_id = $login_userdata['UserID'];
        $this->session->set_userdata('download_user_id', $user_id);
        
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
                if ($Userdetail[$i]['UserID'] == $u_id) {
                    $user = $Userdetail[$i];
                    break;
                }
            }
        }
        $url1 = VIDEO_DETAIL;
        $params1 = "UserId=" . $u_id . "&isHome=0&isProfile=0&Count=100&PageNum=1&VideoID=" . $video_id;
        $response_video1 = $this->getapi->GetApiData($url1, $params1);
        
        if (sizeof($user) > 0 && sizeof($response_video1['videodetails']) > 0) {
            $ProductKey = @$response_video1['videodetails'][0]['ProductKey'];
            $NetworkKey = @$user['NetworkKey'];
            if($ProductKey == '' || $NetworkKey == ''){
                $this->session->unset_userdata('download_user_id');
            $this->session->set_flashdata('danger', 'Paywall is not set.');
            redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
            }
            $userKey = $email_id . '_' . rand(0000000000, 9999999999);
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
                . "networkKey=" . $NetworkKey. "&"
                . "data%5BproductKey%5D=".$ProductKey."&"
                . "data%5BuserKey%5D=" . $userKey . "&"
                . "data%5Bemail%5D=" . $email_id . "&"
                . "successGoBackUrl%5D=" . base_url() . '/' . $video_id . '/' . $u_id,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                //echo "cURL Error #:" . $err;
                 $this->session->set_flashdata('danger', 'Paywall is not set.');
            redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
            } else {
              $payment_url = (array) json_decode($response);
                $urlll = $payment_url['paymentPageUrl'];
                echo "<script>window.location.href='$urlll';</script>";
            }
        }else{
            $this->session->set_flashdata('danger', 'Paywall is not set.');
            redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
        }
    }

    public function payment_success($video_id, $u_id) {

        $USER_KEY = $this->session->userdata('DOWNLOAD_USERKEY');
        $user_id = $this->session->userdata('download_user_id');

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
                if ($Userdetail[$i]['UserID'] == $u_id) {
                    $user = $Userdetail[$i];
                    break;
                }
            }
        }
        $url1 = VIDEO_DETAIL;
        $params1 = "UserId=" . $u_id . "&isHome=0&isProfile=0&Count=100&PageNum=1&VideoID=" . $video_id;
        $response_video1 = $this->getapi->GetApiData($url1, $params1);
        
        if (sizeof($user) > 0 && sizeof($response_video1['videodetails']) > 0) {
            $ProductKey = @$response_video1['videodetails'][0]['ProductKey'];
            $NetworkKey = @$user['NetworkKey'];
           
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
            . "productKey=".$ProductKey."&"
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
            echo "cURL Error #:" . $err;
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
                . "&networkKey=" . NETWORK_KEY . ""
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
                echo "cURL Error #:" . $err1;
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
                $user_id = $login_userdata['UserID'];

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
//exit;
                if ($return == 0) {
                    $this->session->set_flashdata('success', 'Payment Successfully.');
                    redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
                } else {
                    $this->session->set_flashdata('danger', 'Payment Failed.');
                    redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
                }
            }
        } else {
            $this->session->set_flashdata('danger', 'Payment Failed.');
            redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
        }
    }else{
            $this->session->set_flashdata('danger', 'Payment Failed.');
            redirect(base_url() . 'Videos/one_video/' . $video_id . '/' . $u_id);
        
    }
    }

}

?>