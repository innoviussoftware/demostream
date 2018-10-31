<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Upload');
    }

    public function view_banner() {

        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/add_banner');
        $this->load->view('admin/includes/footer');
    }

    public function viewall_banner() {
        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        $video_url1 = Banner_Detail . '?UserId=' . $UserID;
        $video_data1 = curl_init();
        curl_setopt($video_data1, CURLOPT_URL, $video_url1);
        curl_setopt($video_data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($video_data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($video_data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($video_data1, CURLOPT_SSL_VERIFYPEER, 0);
        $responsevideo1 = json_decode(curl_exec($video_data1), true);
        curl_close($video_data1);
        $responsevideo1;

        $data['banner_detail'] = $responsevideo1['bannerdetails'];

        //echo "<pre>";print_r($data['banner_detail']);exit;
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/top_header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/pages/view_banner', $data);
        $this->load->view('admin/includes/footer');
    }

    public function add_new_banner() {


        $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

       // mkdir('uploads/banner/' . $UserID);
       
       $path = 'uploads/banner/' . $UserID;
        if (!is_dir($path)) {
            mkdir($path);
            //mkdir('uploads/banner/' . $UserID);
        }

        $Domain = $this->input->post('domain');
        $background_image_total = $this->input->post('background_image_total');
        $user_id = $this->session->userdata('login_userdata');
        $background_image = $this->input->post('background_image');
        $image_url = $this->input->post('image_url');
        $code = $this->input->post('code');

        $files = $_FILES['background_image'];
        $count = count($_FILES['background_image']['name']);
        $multi_uploaded = $this->Upload->do_upload_banner($files, $count, $UserID);
        $documents_name = array();

        //exit;
        $id = round(microtime(true));
	//print_r($multi_uploaded);exit;
        if (sizeof($multi_uploaded) > 0) {
            for ($i = 0; $i < sizeof($multi_uploaded); $i++) {
                $file_name[] = $multi_uploaded[$i]['upload_data']['file_name'];
                $file_path[] = $multi_uploaded[$i]['upload_data']['file_path'];
                $full_path[] = "uploads/banner/" . $UserID . "/" . $multi_uploaded[$i]['upload_data']['file_name'];
            }
        }

        // $logo = $filepath.$filename;
        // $background = array();
        $image = $full_path;

        for ($r = 0; $r < $count; $r++) {
            $background = array('url' => $image_url[$r], 'image' => $image[$r], 'code' => $code[$r]);
            $back_img = json_encode($background);
              $valid_url = $image_url[$r];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $valid_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_exec($ch);

            $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);
            if ($http != 404) {
                $valid_url = $url;
            } else {
                $valid_url = '';
            }

            $data = array
                (
                "Id" => 0,
                "UserId" => $user_id['UserID'],
                "BackgroundImage" => base_url() . $image[$r],
                "CreatedOn" => date('Y-m-d h:i:s'),
                "UpdatedOn" => date('Y-m-d h:i:s'),
                "IsDeleted" => 0,
                "code" => $code[$r],
                "redirecturl" => $valid_url
            );

           $datajson['manageclientslogo'][0] = $data;
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
                $this->session->set_flashdata('success', 'Banner Added Successfully.');
            } else {
                $this->session->set_flashdata('danger', 'Banner Added Failed.');
            }
        }
        redirect(base_url() . "admin/Banner/view_banner");
    }


    public function delete_banner($id) {
// $id;
        
         $user = $this->session->userdata('login_userdata');
        $UserID = $user['UserID'];

        $video_url1 = Banner_Detail . '?UserId=' . $UserID;
        $video_data1 = curl_init();
        curl_setopt($video_data1, CURLOPT_URL, $video_url1);
        curl_setopt($video_data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($video_data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($video_data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($video_data1, CURLOPT_SSL_VERIFYPEER, 0);
        $responsevideo1 = json_decode(curl_exec($video_data1), true);
        curl_close($video_data1);
        $responsevideo1;

        $data['banner_detail'] = $responsevideo1['bannerdetails'];
        for ($z = 0; $z < sizeof($data['banner_detail']); $z ++) {
            if ($data['banner_detail'][$z]['Id'] == $id) {
                $data['single_banner'] = $data['banner_detail'][$z];
                break;
            }
        }

        //echo "<pre>";print_r($data['banner_detail']);

        $data = array
            (
            "Id" => $id,
            "UserId" => $data['banner_detail']['UserId'],
            "BackgroundImage" => $data['banner_detail']['BackgroundImage'],
            "CreatedOn" => $data['banner_detail']['CreatedOn'],
            "UpdatedOn" => $data['banner_detail']['UpdatedOn'],
            "IsDeleted" => 1
        );
        //echo "<pre>"; print_r($data);exit; 
        $datajson['manageclientslogo'][0] = $data;
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

        if ($return == 0) {
            $this->session->set_flashdata('success', 'Banner Deleted Successfully.');
        } else {
            $this->session->set_flashdata('danger', 'Banner Deleted Failed.');
        }
        redirect(base_url() . "admin/Banner/viewall_banner");

    }
}
?>