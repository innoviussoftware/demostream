<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function view($page = 'home') {
        if (!file_exists(APPPATH . "views/pages/" . $page . ".php")) {
            show_404();
            exit;
        }
        if ($page == 'donate') {
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
                    $network_key = 'testSite';
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
//                             echo "cURL Error #:" . $err;exit;
                        } else {
//                            echo $response;
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
                            }
                        }
                    }
                }
            }
        }

        if ($page == 'home') {
            redirect('Video_curl/campaign');
        } else {
            $this->load->view('includes/header');
            $this->load->view('includes/top-menu');
            $this->load->view('pages/' . $page);
            $this->load->view('includes/footer');
        }
    }

    public function page($page = 'about') {
        if (!file_exists(APPPATH . "views/pages/" . $page . ".php")) {
            show_404();
            exit;
        }

        $this->load->view('pages/' . $page);
        $this->load->view('includes/footer');
    }

}
