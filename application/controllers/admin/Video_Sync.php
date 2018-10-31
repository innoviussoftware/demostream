<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video_Sync extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Upload');
    }

    public function donate_paywall() {
        $network_key = $this->input->post('network_key');
        $user_id = $_POST['user_id'];

//        $network_key = 'testSite';

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
            //START Adding Product and relation between paywall
            $paywall_id = $this->input->post('donate_paywall');
            $product_key = 'Product_Donate_' . $user_id . '_' . rand(0000000, 9999999);
            $product_name = 'Donate Video: ' . $user["FirstName"] . '_' . $user_id;
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

            //END Adding Product and relation between paywall
            if ($product_id != '' && $relation_id != '') {
                $productKey = $product_key;
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
                "ProductKey" => @$productKey,
                "NetworkKey" => $network_key,
                "PaywallId" => $paywall_id
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

                $userdata = array('userID' => $response_datas['userprofiledetails'][0]);

                $this->session->set_userdata('login_userdata', $userdata['userID']);
                
                $this->session->set_flashdata('success', 'Donate paywall updated successfully.');
                redirect(base_url() . "admin/Video_Sync/view_video");
            } else {
                $this->session->set_flashdata('danger', 'Donate paywall updated failed.');
                redirect(base_url() . "admin/Video_Sync/view_video");
            }
        } else {
            $this->session->set_flashdata('danger', 'Donate paywall updated failed.');
            redirect(base_url() . "admin/Video_Sync/view_video");
        }
    }

    public function get_paywall_list() {

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        // if(isset($user['NetworkKey']) && $UserID != '' && $user['NetworkKey'] != ''){
        $network_key = @$user['NetworkKey'];
//        $network_key = 'testSite';
        if ($network_key == '' && $network_key != 'null') {
            echo 1;
            exit;
            // $dealer_data = $this->session->userdata('dealer_data');
            // $dealer_id = $dealer_data['UserID'];
            // $network_key = @$dealer_data['NetworkKey'];
            //$network_key = 'ravi.mca@gmail.com_43';
        }
        $product_type = $_POST['product_type'];
        $download_paywall = '';
        $download_paywall = $_POST['download_paywall'];
        $ningnetwork = $this->ningnetwork->GetPaywallList($network_key, $product_type);
        if ($ningnetwork['error_code'] == 0 && count($ningnetwork['data']) > 0) {
            $paywalls = $ningnetwork['data'];
            $html = '<option value="">Select Paywall</option>';
            for ($i = 0; $i < sizeof($paywalls); $i++) {
                $paywall = (array) $paywalls[$i];
                $id = $paywall['id'];
                $name = $paywall['name'];
                if ($paywall['type'] == $product_type) {
                    if ($id == @$user['PaywallId'] && $product_type == '2') {
                        $html .= '<option value="' . $id . '" selected="" >' . $name . ' [' . $id . ']</option>';
                    } else {
                        if ($id != '11E859C98D8C6118995314187767603C' && $id != '11E85C7503F90873995314187767603C' && $id != '11E85A9BC88A7C95995314187767603C') {
                            // if($id != '11E88BC9272B8549995314187767603C' && $id != '11E88C045C199A0E995314187767603C' && $id != '11E88B7EE5F93166995314187767603C'){
                            $selected = '';
                            if ($download_paywall == $id) {
                                $selected = ' selected ';
                            }
                            $html .= '<option value="' . $id . '" ' . $selected . '>' . $name . ' [' . $id . ']</option>';
                        }
                    }
                }
            }
            echo $html;
            exit;
        } else {
            echo 0;
            exit;
        }
        // }else{
        // echo 0;exit;
        // }
    }

    public function paywall_network_admin_url() {
        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        // if (isset($user['NetworkKey']) && $UserID != '' && $user['NetworkKey'] != '') {
        $network_key = $user['NetworkKey'];
//        $network_key = 'testSite';
        $ningnetwork = $this->ningnetwork->GetOtpForNetwork($user['EmailID'], $network_key); //email and network key
        if ($ningnetwork['error_code'] == 0) {
            $url = $ningnetwork['data'];
            echo "<script>window.location.href='$url';</script>";
            exit;
        } else {
            $url = 'https://e-commerce.ning.com/login/admin';
            echo "<script>window.location.href='$url';</script>";
            exit;
        }
        // } else {
        $url = 'https://e-commerce.ning.com/login/admin';
        echo "<script>window.location.href='$url';</script>";
        exit;
        // }
    }

    public function view_video() {

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
        if (($user['IsAdmin'] == 1 || $user['IsAdmin'] == '') && $user['UserID'] != 1) {
            $isHome = 0;
        } else {
            $isHome = 1;
        }
        $url = VIDEO . "?UserId=" . $UserID . "&Count=1000&PageNum=1&isHome=" . $isHome . "&isProfile=0";
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

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/video', $video_detail);
        $this->load->view('admin/includes/footer');
    }

    public function edit($id) {

        $VideoID = $id;

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
        $url1 = VIDEO_DETAIL . "?UserId=" . $UserID . "&isHome=0&isProfile=0&Count=1000&PageNum=1&VideoID=" . $VideoID;

        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url1);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);
        $edit_detail['edit_detail'] = $response_data1['videodetails'];

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/edit_video', $edit_detail);
        $this->load->view('admin/includes/footer');
    }

    public function delete($id) {

        $VideoID = $id;
        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
        $url1 = VIDEO_DETAIL . "?UserId=" . $UserID . "&isHome=1&isProfile=1&Count=100&PageNum=1&VideoID=" . $VideoID;

        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url1);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        @$edit_detail['delete_detail'] = $response_data1['videodetails'][0];

        if ($edit_detail['delete_detail']['IsPayment'] == 0) {
            $IsPayment = 'false';
        } else if ($edit_detail['delete_detail']['IsPayment'] == 1) {
            $IsPayment = 'true';
        }
        if ($edit_detail['delete_detail']['IsPublic'] == 0) {
            $IsPublic = 'false';
        } else if ($edit_detail['delete_detail']['IsPublic'] == 1) {
            $IsPublic = 'true';
        }
        if ($edit_detail['delete_detail']['CanBuy'] == 0) {
            $CanBuy = 'false';
        } else if ($edit_detail['delete_detail']['CanBuy'] == 1) {
            $CanBuy = 'true';
        }
        if ($edit_detail['delete_detail']['CanCollaborate'] == 0) {
            $CanCollaborate = 'false';
        } else if ($edit_detail['delete_detail']['CanCollaborate'] == 1) {
            $CanCollaborate = 'true';
        }
        if ($edit_detail['delete_detail']['CanComment'] == 0) {
            $CanComment = 'false';
        } else if ($edit_detail['delete_detail']['CanComment'] == 1) {
            $CanComment = 'true';
        }
        if ($edit_detail['delete_detail']['CanDonate'] == 0) {
            $CanDonate = 'false';
        } else if ($edit_detail['delete_detail']['CanDonate'] == 1) {
            $CanDonate = 'true';
        }
        if ($edit_detail['delete_detail']['CanShare'] == 0) {
            $CanShare = 'false';
        } else if ($edit_detail['delete_detail']['CanShare'] == 1) {
            $CanShare = 'true';
        }


        $data = array
            (
            "Amount" => $edit_detail['delete_detail']['Amount'],
            "CanBuy" => $CanBuy,
            "CanCollaborate" => $CanCollaborate,
            "CanComment" => $CanComment,
            "CanDonate" => $CanDonate,
            "CanShare" => $CanShare,
            "CreatedOn" => date('Y-m-d h:i:s'),
            "CreatedOnMobile" => date('Y-m-d h:i:s'),
            "Description" => $edit_detail['delete_detail']['Description'],
            "DeviceID" => $edit_detail['delete_detail']['DeviceID'],
            "IsFrontPage" => 'false',
            "IsPayment" => $IsPayment,
            "IsPublic" => $IsPublic,
            "IsSync" => "false",
            "Title" => $edit_detail['delete_detail']['Title'],
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UserID" => $edit_detail['delete_detail']['UserID'],
            "VideoID" => $edit_detail['delete_detail']['VideoID'],
            "VideoPath" => $edit_detail['delete_detail']['VideoPath'],
            "VideoSize" => $edit_detail['delete_detail']['VideoSize'],
            "WrapperPath" => $edit_detail['delete_detail']['WrapperPath'],
            "isBtnConfig" => "false",
            "IsDeleted" => "true"
        );

//echo "<pre>";print_r($data);exit;
        $datajson['videodetails'][0] = $data;
        $data_string = json_encode($datajson);
        $data_string = str_replace("\\/", "/", $data_string);
//exit;
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
        if ($return == 0) {
            $this->session->set_flashdata('success', 'Video deleted Successfully.');
            redirect(base_url() . "admin/Video_Sync/view_video");
        } else {

            $this->session->set_flashdata('success', 'Video deleted Successfully.');
            redirect(base_url() . "admin/Video_Sync/view_video");
        }
    }

    public function edit_video_detail() {

        if ($this->input->post('Submit') != '') {
            $VideoID = $this->input->post('VideoID');
            $user = $this->session->userdata('login_userdata');
            $UserID = $user['UserID'];
            $network_key = '';
            if (isset($user['NetworkKey']) && $UserID != '' && $user['NetworkKey'] != '') {
                $network_key = $user['NetworkKey'];
            }

            $url1 = VIDEO_DETAIL . "?UserId=" . $UserID . "&isHome=0&isProfile=0&Count=100&PageNum=1&VideoID=" . $VideoID;
            $data = curl_init();
            curl_setopt($data, CURLOPT_URL, $url1);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_PROXYPORT, 3128);
            curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
            $response_data1 = json_decode(curl_exec($data), true);
            $return = curl_errno($data);
            curl_close($data);
            $video_detail['video_detail'] = $response_data1['videodetails'][0];

            if ($video_detail['video_detail']['IsPublic'] == 0) {
                $IsPublic = 'false';
            } else if ($video_detail['video_detail']['IsPublic'] == 1) {
                $IsPublic = 'true';
            }
            if ($video_detail['video_detail']['CanDonate'] == 0) {
                $CanDonate = 'false';
            } else if ($video_detail['video_detail']['CanDonate'] == 1) {
                $CanDonate = 'true';
            }
            if ($video_detail['video_detail']['CanShare'] == 0) {
                $CanShare = 'false';
            } else if ($video_detail['video_detail']['CanShare'] == 1) {
                $CanShare = 'true';
            }
            if ($video_detail['video_detail']['CanBuy'] == 0) {
                $CanBuy = 'false';
            } else if ($video_detail['video_detail']['CanBuy'] == 1) {
                $CanBuy = 'true';
            }
            if ($video_detail['video_detail']['CanCollaborate'] == 0) {
                $CanCollaborate = 'false';
            } else if ($video_detail['video_detail']['CanCollaborate'] == 1) {
                $CanCollaborate = 'true';
            }
            if ($video_detail['video_detail']['IsFrontPage'] == 0) {
                $IsFrontPage = 'false';
            } else if ($video_detail['video_detail']['IsFrontPage'] == 1) {
                $IsFrontPage = 'true';
            }
            if ($video_detail['video_detail']['CanComment'] == 0) {
                $CanComment = 'false';
            } else if ($video_detail['video_detail']['CanComment'] == 1) {
                $CanComment = 'true';
            }
            if ($video_detail['video_detail']['IsPayment'] == 0) {
                $IsPayment = 'false';
            } else if ($video_detail['video_detail']['IsPayment'] == 1) {
                $IsPayment = 'true';
            }
            if ($video_detail['video_detail']['IsBtnConfig'] == 0) {
                $isBtnConfig = 'false';
            } else if ($video_detail['video_detail']['IsBtnConfig'] == 1) {
                $isBtnConfig = 'true';
            }
            if ($video_detail['video_detail']['IsDeleted'] == 0) {
                $IsDeleted = 'false';
            } else if ($video_detail['video_detail']['IsDeleted'] == 1) {
                $IsDeleted = 'true';
            }


            if ($network_key != '' && $network_key != 'null') {
                $paywall_id = $this->input->post('paywall');
                $product_key = 'Product_' . $UserID . '_' . rand(0000000, 9999999);
                $product_name = 'Download Video: ' . $this->input->post('Title');
                //$download_amount = $this->input->post('download_amount');
                try {
                    $ning_product = $this->ningnetwork->CreateProductForNetwork($paywall_id, $product_key, $product_name, $network_key, $product_type = 1);
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
            $ProductKey = '';
            $PaywallID = '';
            if ($product_id != '' && $relation_id != '') {
                $ProductKey = $product_key;
                $PaywallID = $paywall_id;
                $IsPayment = 'true';
            } else {
                $IsPayment = 'false';
            }

            $data_post = array
                (
                "Amount" => $video_detail['video_detail']['Amount'],
                "CanBuy" => $CanBuy,
                "CanCollaborate" => $CanCollaborate,
                "CanComment" => $CanComment,
                "CanDonate" => $CanDonate,
                "CanShare" => $CanShare,
                "CreatedOn" => date('Y-m-d h:i:s'),
                "CreatedOnMobile" => date('Y-m-d h:i:s'),
                "Description" => $this->input->post('Description'),
                "DeviceID" => $video_detail['video_detail']['DeviceID'],
                "IsFrontPage" => $IsFrontPage,
                "IsPayment" => $IsPayment,
                "IsPublic" => $IsPublic,
                "IsSync" => 'false',
                "Title" => $this->input->post('Title'),
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                "UserID" => $video_detail['video_detail']['UserID'],
                "VideoID" => $VideoID,
                "VideoPath" => $video_detail['video_detail']['VideoPath'],
                "VideoSize" => $video_detail['video_detail']['VideoSize'],
                "WrapperPath" => $video_detail['video_detail']['WrapperPath'],
                "isBtnConfig" => $isBtnConfig,
                "isDeleted" => $IsDeleted,
                "ProductKey" => $ProductKey,
                "PaywallName" => $PaywallID,
                "PaywallId" => $PaywallID
            );

            $datajson['videodetails'][] = $data_post;
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
                $this->session->set_flashdata('success', 'Video updated Successfully.');
                redirect(base_url() . "admin/Video_Sync/view_video");
            } else {

                $this->session->set_flashdata('success', 'Video updated Successfully.');
                redirect(base_url() . "admin/Video_Sync/view_video");
            }
            curl_close($ch);
        }
    }

//    public function success_video() {
//
//        $this->load->library('Youtube');
//        $filename = $this->session->userdata('filename');
//        $filepath = $this->session->userdata('filepath');
//        $title = $this->session->userdata('title');
//        $description = $this->session->userdata('description');
//        $tag = $this->session->userdata('tag');
//        $state = $_REQUEST['state'];
//        @$code = $_REQUEST['code'];
//        $uploade_library = $this->youtube->upload_video($filename, $filepath, $title, $description, $tag, $state, $code);
//        $url = '';
//        if (sizeof($uploade_library) > 0) {
//            $url = $uploade_library['url'];
//            $this->session->set_flashdata('success_upload_video', $url);
//        }
//
//        $uploade_datas = $this->session->userdata('Upload_data');
//
//        $DeviceID = round(microtime(true));
//        $user = $this->session->userdata('login_userdata');
//        $UserID = $user['UserID'];
//
//        $data = array
//            (
//            "Amount" => '',
//            "CanBuy" => 'false',
//            "CanCollaborate" => 'false',
//            "CanComment" => 'false',
//            "CanDonate" => 'false',
//            "CanShare" => 'false',
//            "CreatedOn" => 'false',
//            "CreatedOnMobile" => date('Y-m-d h:i:s'),
//            "Description" => $uploade_datas['Description'],
//            "DeviceID" => $DeviceID,
//            "IsFrontPage" => 'false',
//            "IsPayment" => 'false',
//            "IsPublic" => 'true',
//            "IsSync" => "false",
//            "Title" => $uploade_datas['Title'],
//            "UpdatedOn" => date('Y-m-d h:i:s'),
//            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
//            "UserID" => $UserID,
//            "VideoID" => 0,
//            "VideoPath" => $uploade_library['url'],
//            "VideoSize" => 0,
//            "WrapperPath" => $uploade_library['WrapperPath'],
//            "isBtnConfig" => "false",
//            "isDeleted" => "false"
//        );
//        $TagID = round(microtime(true));
//        $data1 = array
//            (
//            "HashTag" => $uploade_datas['VideoHashTagID'],
//            "IsSync" => "false",
//            "VideoHashTagID" => $TagID,
//            "VideoID" => 0
//        );
//
//        $datajson['videodetails'][0] = $data;
//        $datajson['videohashtag'][0] = $data1;
//        $data_string = json_encode($datajson);
//        $data_string = str_replace("\\/", "/", $data_string);
//
//        $url2 = SYNCTODB;
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url2);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//
//        $response_data = curl_exec($ch);
//        $return = curl_errno($ch);
//
//        $this->session->unset_userdata('Upload_data');
//
//        if ($url != '') {
//            $this->session->set_flashdata('success', 'Video uploaded successfully.');
//        } else {
//            $this->session->set_flashdata('danger', 'Video uploaded failed.');
//        }
//
//        redirect(base_url() . "admin/Video_Sync/view_video");
//    }
    //Video will upload on youtube
    public function add_new_video() {
        ini_set('max_execution_time', 0);
        $this->session->set_userdata('Upload_data', $_POST);
        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        if (isset($user['NetworkKey']) && $UserID != '' && $user['NetworkKey'] != '') {
            $network_key = $user['NetworkKey'];
        }

        $uploaded = $this->Upload->do_upload('userfile');
        @$file_name = $uploaded['userfile']['file_name'];

        $VideoID = round(microtime(true));
        $DeviceID = round(microtime(true));
        @$filename = $uploaded['upload_data']['file_name'];
        @$filepath = $uploaded['upload_data']['file_path'];
        $title = $this->input->post('Title');
        $description = $this->input->post('Description');
        $tag = $this->input->post('VideoHashTagID');
        $this->input->post('valid_url');
        if ($this->input->post('valid_url') != '' && $uploaded['error'] != '') {
            $url = $this->input->post('valid_url');

            if ($network_key != '' && $network_key != 'null') {
                $paywall_id = $this->input->post('paywall');
                $product_key = 'Product_' . $UserID . '_' . rand(00000000, 99999999);
                $product_name = 'Download Video: ' . $title;
//                $download_amount = $this->input->post('download_amount');
                try {
                    $ning_product = $this->ningnetwork->CreateProductForNetwork($paywall_id, $product_key, $product_name, $network_key, $product_type = 1);
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
            } else {
                $product_id = '';
                $relation_id = '';
                $ProductKey = '';
                $PaywallID = '';
            }
            if ($product_id != '') {
                $IsPayment = 'true';
            } else {
                $IsPayment = 'false';
            }
            if ($product_id != '' && $relation_id != '') {
                $ProductKey = $product_key;
                $PaywallID = $paywall_id;
            }

            $data = array
                (
                "Amount" => '',
                "CanBuy" => 'false',
                "CanCollaborate" => 'false',
                "CanComment" => 'false',
                "CanDonate" => 'false',
                "CanShare" => 'false',
                "CreatedOn" => 'false',
                "CreatedOnMobile" => date('Y-m-d h:i:s'),
                "Description" => $description,
                "DeviceID" => $DeviceID,
                "IsFrontPage" => 'true',
                "IsPayment" => $IsPayment,
                "IsPublic" => 'true',
                "IsSync" => "false",
                "Title" => $title,
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                "UserID" => $UserID,
                "VideoID" => 0,
                "VideoPath" => $url,
                "VideoSize" => 0,
                "WrapperPath" => '',
                "isBtnConfig" => "false",
                "isDeleted" => "false",
                "ProductKey" => @$ProductKey,
                "PaywallName" => @$PaywallID
            );
            $TagID = round(microtime(true));
            $data1 = array
                (
                "HashTag" => $tag,
                "IsSync" => "false",
                "VideoHashTagID" => $TagID,
                "VideoID" => 0
            );

            $datajson['videodetails'][0] = $data;
            $datajson['videohashtag'][0] = $data1;
            $data_string = json_encode($datajson);
            $data_string = str_replace("\\/", "/", $data_string);

            $url2 = SYNCTODB;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url2);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response_data = curl_exec($ch);
            $return1 = curl_errno($ch);
            curl_close($ch);
            if ($url != '' && $return1 == 0) {
                $this->session->unset_userdata('Upload_data');
                $this->session->set_flashdata('success_upload_video', $url);
                $this->session->set_flashdata('success', 'Video uploaded successfully.');
                echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                exit;
            } else {
                $this->session->set_flashdata('danger', 'Video uploaded failed.');
                echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                exit;
            }
        }
        if ($filename != '' && $filepath != '' && $this->input->post('valid_url') == '') {
            $this->session->set_userdata('filename', $filename);
            $this->session->set_userdata('filepath', $filepath);
            $this->session->set_userdata('title', $title);
            $this->session->set_userdata('description', $description);
            $this->session->set_userdata('tag', $tag);

            //ISS - Vishal
            echo "<script>window.location.href='" . base_url() . "admin/Video_Sync/authGmailAndUploadToYoutube';</script>";
            exit;
        } else {
            $this->session->set_flashdata('danger', 'Select small size video and try again.');
            echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
        }
    }

    public function update_checkbox() {
        $VideoID = $this->input->post('VideoID');
        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        $url1 = VIDEO_DETAIL . "?UserId=" . $UserID . "&isHome=1&isProfile=1&Count=100&PageNum=1&VideoID=" . $VideoID;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url1);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data), true);
        $return = curl_errno($data);
        curl_close($data);
//echo '<pre>';print_r($response_data1);exit;
        $video_detail['video_detail'] = $response_data1['videodetails'][0];

//        print_r($video_detail['video_detail']);

        $Value = $this->input->post('Value');
        $Name = $this->input->post('Name');

        if ($Name == 'IsPublic') {
            if ($Value == 1) {
                $IsPublic = 'false';
            } else if ($Value == 0) {
                $IsPublic = 'true';
            }
        } else {
            if ($video_detail['video_detail']['IsPublic'] == 0) {
                $IsPublic = 'false';
            } else if ($video_detail['video_detail']['IsPublic'] == 1) {
                $IsPublic = 'true';
            }
        }

        if ($Name == 'CanDonate') {
            if ($Value == 1) {
                $CanDonate = 'false';
            } else if ($Value == 0) {
                $CanDonate = 'true';
            }
        } else {
            if ($video_detail['video_detail']['CanDonate'] == 0) {
                $CanDonate = 'false';
            } else if ($video_detail['video_detail']['CanDonate'] == 1) {
                $CanDonate = 'true';
            }
        }

        if ($Name == 'CanShare') {
            if ($Value == 1) {
                $CanShare = 'false';
            } else if ($Value == 0) {
                $CanShare = 'true';
            }
        } else {
            if ($video_detail['video_detail']['CanShare'] == 0) {
                $CanShare = 'false';
            } else if ($video_detail['video_detail']['CanShare'] == 1) {
                $CanShare = 'true';
            }
        }

        if ($Name == 'CanBuy') {
            if ($Value == 1) {
                $CanBuy = 'false';
            } else if ($Value == 0) {
                $CanBuy = 'true';
            }
        } else {
            if ($video_detail['video_detail']['CanBuy'] == 0) {
                $CanBuy = 'false';
            } else if ($video_detail['video_detail']['CanBuy'] == 1) {
                $CanBuy = 'true';
            }
        }

        if ($Name == 'CanCollaborate') {
            if ($Value == 1) {
                $$CanCollaborate = 'false';
            } else if ($Value == 0) {
                $CanCollaborate = 'true';
            }
        } else {
            if ($video_detail['video_detail']['CanCollaborate'] == 0) {
                $CanCollaborate = 'false';
            } else if ($video_detail['video_detail']['CanCollaborate'] == 1) {
                $CanCollaborate = 'true';
            }
        }

        if ($Name == 'IsFrontPage') {
            if ($Value == 1) {
                $IsFrontPage = 'false';
            } else if ($Value == 0) {
                $IsFrontPage = 'true';
            }
        } else {
            if ($video_detail['video_detail']['IsFrontPage'] == 0) {
                $IsFrontPage = 'false';
            } else if ($video_detail['video_detail']['IsFrontPage'] == 1) {
                $IsFrontPage = 'true';
            }
        }

        if ($video_detail['video_detail']['CanComment'] == 0) {
            $CanComment = 'false';
        } else if ($video_detail['video_detail']['CanComment'] == 1) {
            $CanComment = 'true';
        }

        if ($video_detail['video_detail']['IsPayment'] == 0) {
            $IsPayment = 'false';
        } else if ($video_detail['video_detail']['IsPayment'] == 1) {
            $IsPayment = 'true';
        }

        if ($video_detail['video_detail']['IsBtnConfig'] == 0) {
            $isBtnConfig = 'false';
        } else if ($video_detail['video_detail']['IsBtnConfig'] == 1) {
            $isBtnConfig = 'true';
        }

        if ($video_detail['video_detail']['IsDeleted'] == 0) {
            $IsDeleted = 'false';
        } else if ($video_detail['video_detail']['IsDeleted'] == 1) {
            $IsDeleted = 'true';
        }

        $data_post = array
            (
            "Amount" => $video_detail['video_detail']['Amount'],
            "CanBuy" => $CanBuy,
            "CanCollaborate" => $CanCollaborate,
            "CanComment" => $CanComment,
            "CanDonate" => $CanDonate,
            "CanShare" => $CanShare,
            "CreatedOn" => date('Y-m-d h:i:s'),
            "CreatedOnMobile" => date('Y-m-d h:i:s'),
            "Description" => $video_detail['video_detail']['Description'],
            "DeviceID" => $video_detail['video_detail']['DeviceID'],
            "IsFrontPage" => $IsFrontPage,
            "IsPayment" => $IsPayment,
            "IsPublic" => $IsPublic,
            "IsSync" => 'false',
            "Title" => $video_detail['video_detail']['Title'],
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UserID" => $video_detail['video_detail']['UserID'],
            "VideoID" => $VideoID,
            "VideoPath" => $video_detail['video_detail']['VideoPath'],
            "VideoSize" => $video_detail['video_detail']['VideoSize'],
            "WrapperPath" => $video_detail['video_detail']['WrapperPath'],
            "isBtnConfig" => $isBtnConfig,
            "isDeleted" => $IsDeleted
        );

// echo '<pre>';        print_r($data_post);exit;

        $datajson['videodetails'][] = $data_post;
        $data_string = json_encode($datajson);
        $data_string = str_replace("\\/", "/", $data_string);
//exit;
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
//exit;
        curl_close($ch);
    }

    public function select_one_video() {

        $video_id = $this->input->post('video_id');
//echo "<pre>";

        $VideoID = $video_id;

        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];
        $url1 = VIDEO_DETAIL . "?UserId=" . $UserID . "&isHome=1&isProfile=0&Count=100&PageNum=1&VideoID=" . $VideoID;
//$url = VIDEO . "?UserId=" . $UserID . "&Count=5&PageNum=1&isHome=0&isProfile=0";
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url1);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $one_video = $response_data1['videodetails'][0];
//echo '<pre>';print_r($one_video);
        $url = ACTIVITY . "?VideoID=" . $VideoID . "&Count=100&PageNum=1";
//$url = VIDEO . "?UserId=" . $UserID . "&Count=5&PageNum=1&isHome=0&isProfile=0";
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data);
        curl_close($data);

//        echo '<pre>';print_r($response_data);exit;
        $update_activity = $response_data['campaignactivityupdates'];
        $count_activity = sizeof($update_activity);

        echo $html = '<ul class="list-group">
	              			<label style="float:left;font-size:125%;margin-left:2%;background:#8B008B;width:100%;margin:0px;padding:2%;color:white;"><b>Activity Updates</b></label>';

        if ($count_activity > 0) {
            for ($r = 0; $r < $count_activity; $r++) {
//print_r($update_activity[$r]);
                if ($update_activity[$r]['IsDeleted'] != 1) {
                    $create_date = $update_activity[$r]['CreatedOnMobile'];
                    $create_date = date('Y-m-d', strtotime($create_date));
                    $current_date = date('Y-m-d');

                    $date1 = date_create($create_date);
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

                    $img_Path = $update_activity[$r]['ActivityImgPath'];
                    $a = strpos($update_activity[$r]['ActivityImgPath'], '~');

                    if (strpos($update_activity[$r]['ActivityImgPath'], '~') === 0) {
                        $img_Path = str_replace('~/', '', $img_Path);
                        $img_Path = base_url() . $img_Path;
                    } elseif (strpos($update_activity[$r]['ActivityImgPath'], 'http') === 0) {
                        $img_Path = $img_Path;
                    } else {
                        $img_Path = base_url() . $img_Path;
                    }
                    if ($update_activity[$r]['ActivityImgPath'] == '' || $update_activity[$r]['ActivityImgPath'] == '~/ActivityImages/') {
                        $img_Path = base_url() . 'assets/images/unknown.jpg';
                    }

                    $del_url = base_url() . 'admin/Video_Sync/delete_activity/' . $update_activity[$r]['ActivityUpdateID'] . '/' . $video_id;
                    $onclick = "return confirm('" . $del_url . "', 'activity update')";
                    echo '<table class="table table-striped" >
	                               <tr style="background:none;border-bottom:1px solid #999;">
	                                    <th style="width:25%;">
	                                    <img src="' . $img_Path . '" style="width:100%;height:100px;"/>
	                                    </th>
	                                    <td>   
	                                    <label style="margin-left:5%;">' . $update_activity[$r]['UpdateMessage'] . '</label>
	                                    <br />
	                                    <h5 style="margin-left:5%;">' . $d . '</h5>
	                                    </td>
                                            <td><a href="#" onclick="' . $onclick . '" style="display:none;"><i style="color:red !important;" class="fa fa-trash-o"></i></a></td>
	                                </tr> 
	                            </table></ul>';
                }
            }
        } else {
            echo $html = '<center><label style="font-size:18px;margin:1%;"><b>No Activity Updates</b></ul></label></center>';
        }

        return $html;
    }

    public function activity_update() {

//echo "<pre>";

        $VideoID = $this->input->post('video_id');
        $Message = $this->input->post('message');

        $uploaded = $this->Upload->do_upload_with_folder('userfile', 'ActivityImages');
        @$file_name = $uploaded['userfile']['file_name'];
        $file_desc = json_encode($uploaded);
        $file_desc = str_replace("\\/", "/", $file_desc);

        @$path = '~/ActivityImages/' . $uploaded['upload_data']['file_name'];

        $user = $this->session->userdata('login_userdata');

        $UserID = $user['UserID'];
        $url1 = VIDEO_DETAIL . "?UserId=" . $UserID . "&isHome=1&isProfile=1&Count=100&PageNum=1&VideoID=" . $VideoID;
//$url = VIDEO . "?UserId=" . $UserID . "&Count=5&PageNum=1&isHome=0&isProfile=0";
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url1);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data1 = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);
//        echo '<pre>';
        $video_detail['video_detail'] = $response_data1['videodetails'][0];

        if ($video_detail['video_detail']['IsPublic'] == 0) {
            $IsPublic = 'false';
        } else if ($video_detail['video_detail']['IsPublic'] == 1) {
            $IsPublic = 'true';
        }
        if ($video_detail['video_detail']['IsDeleted'] == 0) {
            $IsDeleted = 'false';
        } else if ($video_detail['video_detail']['IsDeleted'] == 1) {
            $IsDeleted = 'true';
        }

        $CampaignDetID = $video_detail['video_detail']['CampaignDetID'];
        $ActivityUpdateID = round(microtime(true));

        $data = array
            (
            "ActivityImgPath" => $path,
            "ActivityUpdateID" => 0,
            "ActivityDate" => date('Y-m-d h:i:s'),
            "CampaignDetID" => $VideoID,
            "CreatedOn" => date('Y-m-d h:i:s'),
            "CreatedOnMobile" => date('Y-m-d h:i:s'),
            "IsCampaign" => "false",
            "IsDeleted" => "false",
            "IsPublic" => "true",
            "IsSync" => "false",
            "MemberRole" => "Owner",
            "UpdateMessage" => $Message,
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "UserID" => $UserID,
            "updatedOnMobile" => date('Y-m-d h:i:s')
        );
//        print_r($data);

        $datajson['campaignactivityupdates'][] = $data;
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
//        print_r($response_data);
        $return = curl_errno($ch);
        if ($return == 0) {
            $this->session->set_flashdata('success', 'Activity updated successfully.');
            redirect(base_url() . "admin/Video_Sync/view_video");
        } else {
            $this->session->set_flashdata('danger', 'Activity updated failed.');
            redirect(base_url() . "admin/Video_Sync/view_video");
        }

        curl_close($ch);
        redirect(base_url() . "admin/Video_Sync/view_video");
    }

    public function logout_youtube() {

//$client->revokeToken();
        session_destroy();
        redirect(base_url() . "admin/Video_Sync/view_video");
    }

    public function check_validate() {
        $url = $this->input->post('url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($ch);

        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        curl_close($ch);
        if ($http == 200 || $http == 302) {
            echo $url;
        } else {
            echo 1;
        }
    }

    public function delete_activity($id, $VideoID) {
        $url = ACTIVITY . "?VideoID=" . $VideoID . "&Count=100&PageNum=1";

        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data);
        curl_close($data);


        $update_activity = $response_data['campaignactivityupdates'];
        $count_activity = sizeof($update_activity);

        if ($count_activity > 0) {
            for ($r = 0; $r < $count_activity; $r++) {
                if ($update_activity[$r]['ActivityUpdateID'] == $id) {
                    $act = $update_activity[$r];
                    break;
                }
            }
            if ($act['IsPublic'] == 0) {
                $IsPublic = 'false';
            } else {
                $IsPublic = 'true';
            }
            $data = array
                (
                "ActivityImgPath" => $act['ActivityUpdateID'],
                "ActivityUpdateID" => $act['ActivityUpdateID'],
                "ActivityDate" => $act['ActivityDate'],
                "CampaignDetID" => $act['CampaignDetID'],
                "CreatedOn" => $act['CreatedOn'],
                "CreatedOnMobile" => $act['CreatedOnMobile'],
                "IsCampaign" => $act['ActivityUpdateID'],
                "IsDeleted" => "true",
                "IsPublic" => $IsPublic,
                "IsSync" => "false",
                "MemberRole" => $act['MemberRole'],
                "UpdateMessage" => $act['UpdateMessage'],
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "UserID" => $act['UserID'],
                "updatedOnMobile" => date('Y-m-d h:i:s')
            );

            $datajson['campaignactivityupdates'][] = $data;
            $data_string = json_encode($datajson);
            $data_string = str_replace("\\/", "/", $data_string);

            $url1 = SYNCTODB;
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch1, CURLOPT_POST, 1);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

            $response_data = curl_exec($ch1);

            $return = curl_errno($ch1);

            curl_close($ch1);
        }
    }

    public function update_network() {
        if (isset($_POST['submit_network']) && $_POST['submit_network'] != '') {
            $user_id = $this->input->post('user_id');
            $network_key = $this->input->post('network_key');
            $product_key = $this->input->post('product_key');
            $paywall_id = $this->input->post('paywall_id');

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

            if (sizeof($Userdetail) > 0) {
                for ($i = 0; $i < sizeof($Userdetail); $i++) {
                    if ($Userdetail[$i]['UserID'] == $user_id) {
                        $edit_user = $Userdetail[$i];
                        break;
                    }
                }
            }

            $emailid = $edit_user['EmailID'];
            $password = $edit_user['Password'];
            $sub_charge = $edit_user['SubscriptionCharges'];
            $transaction_share = $edit_user['TransactionShare'];
            $VideoPurchaseShare = $edit_user['VideoPurchaseShare'];
            $website = $edit_user['Website'];
            $logo_name = $edit_user['Logo'];
            $domain = $edit_user['Domain'];
            $phone = $edit_user['MobileNo'];

            if ($edit_user['IsAdmin'] == 1) {
                $IsAdmin = 'true';
            } else {
                $IsAdmin = 'false';
            }


            $data1 = array(
                "MobileRowOrderNo" => '0',
                "ProfileID" => $edit_user['ProfileID'],
                "UserID" => $user_id,
                "FirstName" => $edit_user['FirstName'],
                "LastName" => $edit_user['LastName'],
                "Region" => $edit_user['Region'],
                "City" => $edit_user['City'],
                "State" => $edit_user['State'],
                "Country" => $edit_user['Country'],
                "ProfilePICPath" => $edit_user['ProfilePICPath'],
                "DeviceID" => $edit_user['DeviceID'],
                "CreatedOnMobile" => $edit_user['CreatedOnMobile'],
                "CreatedOn" => $edit_user['CreatedOn'],
                "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "AccountName" => $edit_user['AccountName'],
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
                "IsSuperAdmin" => 'false',
                "NetworkKey" => $network_key,
                "ProductKey" => $product_key,
                "PaywallId" => $paywall_id
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

                $userdata = array('userID' => $response_datas['userprofiledetails'][0]);

                $this->session->set_userdata('login_userdata', $userdata['userID']);

                $this->session->set_flashdata('success', 'Your network details updated successfully.');
                redirect(base_url() . "admin/Video_Sync/view_video");
            } else {
                $this->session->set_flashdata('danger', 'Your network details updated failed.');
                redirect(base_url() . "admin/Video_Sync/view_video");
            }
        } else {
            show_404();
            exit;
        }
    }

    public function authGmailAndUploadToYoutube() {
        ini_set('max_execution_time', 0);
        require_once APPPATH . 'third_party/vishal_youtube/google-api/src/Google/autoload.php';
        $OAUTH2_CLIENT_ID = '57917744165-6qt7u91cfm9q90qi90fk1l8r82ifpotd.apps.googleusercontent.com';
        $OAUTH2_CLIENT_SECRET = 'QKFaenrb1rSxsF2i57SMo22A';

        $client = new Google_Client();
        $client->setClientId($OAUTH2_CLIENT_ID);
        $client->setClientSecret($OAUTH2_CLIENT_SECRET);
        $client->setScopes('https://www.googleapis.com/auth/youtube');
//        $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
        $redirect = base_url() . "admin/Video_Sync/authGmailAndUploadToYoutube";
        $client->setRedirectUri($redirect);
// Define an object that will be used to make all API requests.
        $youtube = new Google_Service_YouTube($client);
        $videoData = $this->session->userdata('filename');
        if (isset($_REQUEST['code'])) {
            if (strval($this->session->userdata('state')) != strval($_REQUEST['state'])) {
                //var_dump($this->session->userdata('state'));
                //var_dump($_REQUEST['state']);
                //die('The session state did not match.');
                $this->session->set_flashdata('danger', 'System error.');
                echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                exit;
            }
            $client->authenticate($_REQUEST['code']);
            $this->session->set_userdata('token', $client->getAccessToken());
            header('Location: ' . $redirect);
        }

        if ($this->session->userdata('token')) {
            $client->setAccessToken($this->session->userdata('token'));
            //    if ($client->isAccessTokenExpired()) {
            //     $client->refreshToken($client->getRefreshToken());
            //   $client->getAccessToken();
            // }
        }

//        echo "<pre>";
//        print_r($_SESSION);
//        exit;
// Check to ensure that the access token was successfully acquired.
        if ($client->getAccessToken()) {
            try {
                if (!empty($videoData['youtube_video_id'])) {
                    $videoTitle = $title;
                    $videoDesc = $description;
                    $videoTags = $tag;
                } else {

                    $uploade_datas = $this->session->userdata('Upload_data');
                    if ($uploade_datas['Title'] != '') {

// REPLACE this value with the path to the file you are uploading.
                        $htmlBody = "";
                        $videoPath = 'title.mp4';
                        $videoPath = $this->session->userdata('filepath') . "/" . $this->session->userdata('filename');
                        $videoTitle = $uploade_datas['Title'];
                        $videoInfo = $uploade_datas['Description'];
                        //// Create a snippet with title, description, tags and category ID
// Create an asset resource and set its snippet metadata and type.
// This example sets the video's title, description, keyword tags, and
// video category. 
                        $tag = explode(",", @$uploade_datas['VideoHashTagID']);
                        $snippet = new Google_Service_YouTube_VideoSnippet();
                        $snippet->setTitle($videoTitle);
                        $snippet->setDescription($videoInfo);
                        $snippet->setTags(@$tag);
// Numeric video category. See
// https://developers.google.com/youtube/v3/docs/videoCategories/list
                        $snippet->setCategoryId("22");
// Set the video's status to "public". Valid statuses are "public",
// "private" and "unlisted".
                        $status = new Google_Service_YouTube_VideoStatus();
                        $status->privacyStatus = "public";
// Associate the snippet and status objects with a new video resource.
                        $video = new Google_Service_YouTube_Video();
                        $video->setSnippet($snippet);
                        $video->setStatus($status);
// Specify the size of each chunk of data, in bytes. Set a higher value for
// reliable connection as fewer chunks lead to faster uploads. Set a lower
// value for better recovery on less reliable connections.
                        $chunkSizeBytes = 1 * 1024 * 1024;
// Setting the defer flag to true tells the client to return a request which can be called
// with ->execute(); instead of making the API call immediately.
                        $client->setDefer(true);
// Create a request for the API's videos.insert method to create and upload the video.
                        $insertRequest = $youtube->videos->insert("status,snippet", $video);
// Create a MediaFileUpload object for resumable uploads.
                        $media = new Google_Http_MediaFileUpload(
                                $client, $insertRequest, 'video/*', null, true, $chunkSizeBytes
                        );
                        $media->setFileSize(filesize($videoPath));
// Read the media file and upload it chunk by chunk.
                        $status = false;
                        $handle = fopen($videoPath, "rb");
                        while (!$status && !feof($handle)) {
                            $chunk = fread($handle, $chunkSizeBytes);
                            $status = $media->nextChunk($chunk);
                        }
                        fclose($handle);
// If you want to make other calls after the file upload, set setDefer back to false
                        $client->setDefer(false);
//                $htmlBody .= "<h3>Video Uploaded</h3><ul>";
//                $htmlBody .= sprintf('<li>%s (%s)</li>', $status['snippet']['title'], $status['id']);
//                $htmlBody .= '</ul>';

                        $video_id = $status['id'];
                        $WrapperPath = $status['snippet']['thumbnails']['default']['url'];
//                $htmlBody = array('url' => "https://youtu.be/" . $video_id, 'WrapperPath' => $WrapperPath);
                        if ($video_id) {
                            $url = "https://youtu.be/" . $video_id;
                            //  $this->session->set_flashdata('success_upload_video', $url);

                            $DeviceID = round(microtime(true));
                            $user = $this->session->userdata('login_userdata');
                            $UserID = $user['UserID'];

                            if (isset($user['NetworkKey']) && $UserID != '' && $user['NetworkKey'] != '') {
                                $network_key = $user['NetworkKey'];
                            }

                            if ($network_key != '' && $network_key != 'null') {
                                $paywall_id = $uploade_datas['paywall'];
                                $product_key = 'Product_' . $UserID . '_' . rand(00000000, 99999999);
                                $product_name = 'Download Video: ' . $title;
                                $download_amount = 0;
                                try {
                                    $ning_product = $this->ningnetwork->CreateProductForNetwork($paywall_id, $product_key, $product_name, $network_key, $product_type = 1);
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
                            } else {
                                $product_id = '';
                                $relation_id = '';
                                $ProductKey = '';
                                $PaywallID = '';
                            }
                            if ($product_id != '') {
                                $IsPayment = 'true';
                            } else {
                                $IsPayment = 'false';
                            }
                            $data = array
                                (
                                "Amount" => '',
                                "CanBuy" => 'false',
                                "CanCollaborate" => 'false',
                                "CanComment" => 'false',
                                "CanDonate" => 'false',
                                "CanShare" => 'false',
                                "CreatedOn" => 'false',
                                "CreatedOnMobile" => date('Y-m-d h:i:s'),
                                "Description" => $uploade_datas['Description'],
                                "DeviceID" => $DeviceID,
                                "IsFrontPage" => 'true',
                                "IsPayment" => $IsPayment,
                                "IsPublic" => 'true',
                                "IsSync" => "false",
                                "Title" => $uploade_datas['Title'],
                                "UpdatedOn" => date('Y-m-d h:i:s'),
                                "UpdatedOnMobile" => date('Y-m-d h:i:s'),
                                "UserID" => $UserID,
                                "VideoID" => 0,
                                "VideoPath" => $url,
                                "VideoSize" => 0,
                                "WrapperPath" => $WrapperPath,
                                "isBtnConfig" => "false",
                                "isDeleted" => "false",
                                "ProductKey" => $product_key,
                                "PaywallName" => $paywall_id
                            );
                            $TagID = round(microtime(true));
                            $data1 = array
                                (
                                "HashTag" => $uploade_datas['VideoHashTagID'],
                                "IsSync" => "false",
                                "VideoHashTagID" => $TagID,
                                "VideoID" => 0
                            );

                            $datajson['videodetails'][0] = $data;
                            $datajson['videohashtag'][0] = $data1;
                            $data_string = json_encode($datajson);
                            $data_string = str_replace("\\/", "/", $data_string);

                            $url2 = SYNCTODB;
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url2);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                            $response_data = curl_exec($ch);
                            $return = curl_errno($ch);

                            $this->session->unset_userdata('Upload_data');
                            unlink($videoPath);
                            $this->session->unset_userdata('state');
                            $this->session->keep_flashdata('success_upload_video');
                            $this->session->set_flashdata('success_upload_video', $url);
                            $this->session->keep_flashdata('success');
                            $this->session->set_flashdata('success', 'Video uploaded successfully.');
                            echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                            exit;
                        } else {
                            $this->session->keep_flashdata('success_upload_video');
                            $this->session->set_flashdata('success_upload_video', $url);
                            $this->session->keep_flashdata('success');
                            $this->session->set_flashdata('success', 'Video uploaded successfully.');
                            echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                            exit;
                        }
                    } else {
                        $this->session->keep_flashdata('success_upload_video');
                        $this->session->set_flashdata('success_upload_video', $url);
                        $this->session->keep_flashdata('success');
                        $this->session->set_flashdata('success', 'Video uploaded successfully.');
                        echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                        exit;
                    }
                }
            } catch (Google_ServiceException $e) {
                $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
            } catch (Google_Exception $e) {
                $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
                $this->session->keep_flashdata('success_upload_video');
                $this->session->keep_flashdata('success');
                $this->session->set_flashdata('success_upload_video', $url);
                $this->session->set_flashdata('success', 'Video uploaded successfully.');
                echo '<script>window.location.href="' . base_url() . 'admin/Video_Sync/view_video";</script>';
                exit;
            }
            //$this->session->set_userdata('token', $client->getAccessToken());
        } else {
// If the user hasn't authorized the app, initiate the OAuth flow

            $state = mt_rand();
            $client->setState($state);
            $this->session->set_userdata('state', $state);
            $authUrl = $client->createAuthUrl();
            echo $htmlBody = <<<END
<h3>Authorization Required</h3>
<p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
        }
    }

}

?>
