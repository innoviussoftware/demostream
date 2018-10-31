<?php

class Youtube extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function youtube() {

        $this->load->library('google_client_api');
        //echo "Hii...";
        $v_name = $this->session->userdata('video_name');
        ///echo $this->rahul->my_function();
        //exit;
        $video = "upload/" . $v_name;
        $title = "This is your video";
        $desc = "This is your video.Just play it.Enjoy it.Thank you.";
        $tags = ["uk", "youtubeapi3"];
        $privacy_status = "public";
        $youtube = $this->google_client_api->youtube_upload($video, $title, $desc, $tags, $privacy_status);
    }

    public function upload_video() {

        $this->load->library('google_client_api');
        $code = $_REQUEST['code'];
        $youtube = $this->google_client_api->success_upload($code);
    }

}

?>
