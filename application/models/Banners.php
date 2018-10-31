<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends CI_Model {

    public function __construct() {
        parent::__construct();


    }

    public function get_banner($userid) {
         $userid;
        //$UserID = 141;
        $UserID = $userid;
        $video_url1 = Banner_Detail.'?UserId='.$UserID;
        $video_data1 = curl_init();
        curl_setopt($video_data1, CURLOPT_URL, $video_url1);
        curl_setopt($video_data1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($video_data1, CURLOPT_PROXYPORT, 3128);
        curl_setopt($video_data1, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($video_data1, CURLOPT_SSL_VERIFYPEER, 0);
        $responsevideo1 = json_decode(curl_exec($video_data1), true);
        curl_close($video_data1);
        $responsevideo1;
//print_r($responsevideo1);
        $detail_count = sizeof($responsevideo1['bannerdetails']);
        
        if($detail_count>0)
        {
            return $responsevideo1; 
        }
        else
        {
            $video_url2 = Banner_Detail."?UserId=1";
            $video_data2 = curl_init();
            curl_setopt($video_data2, CURLOPT_URL, $video_url2);
            curl_setopt($video_data2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($video_data2, CURLOPT_PROXYPORT, 3128);
            curl_setopt($video_data2, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($video_data2, CURLOPT_SSL_VERIFYPEER, 0);
            $responsevideo2 = json_decode(curl_exec($video_data2), true);
            curl_close($video_data2);
            $responsevideo2;
//print_r($responsevideo2);
            return $responsevideo2; 

        }
        
    }

}
