<?php 
 
defined('BASEPATH') OR exit('No direct script access allowed');
     
class Video_curl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('share');
		$this->load->library('session');	
    }
	//IsCampaign= 1 refer this function
    public function campaign($video_id = 1) {    
		$iscampaign=1;
		$return=0;
		$Views= $this->session->userdata('ViewCount');
		if(!$this->session->userdata('ViewCount')){ 
			$return=$this->IncreaseCount($iscampaign,$video_id);
			$this->session->set_userdata('ViewCount',$video_id);
		}elseif($Views != $video_id){
			$return=$this->IncreaseCount($iscampaign,$video_id);
			$this->session->set_userdata('ViewCount',$video_id);
		}
		if($return == 0){ 
			$video_url = CAMPAIGN."?CampaignID=".$video_id."&UserDetId=53&Count=25&PageNum=1";	//UserDetId=53 removed this string from URL		
			$video_data = curl_init();
			curl_setopt($video_data, CURLOPT_URL, $video_url);
			curl_setopt($video_data, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($video_data, CURLOPT_PROXYPORT, 3128);
			curl_setopt($video_data, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($video_data, CURLOPT_SSL_VERIFYPEER, 0);
			$responsevideo = json_decode(curl_exec($video_data), true);
			curl_close($video_data);
			
			$size= sizeof($responsevideo['campaigndetails']);
			//echo '<pre>';print_r($responsevideo);
				if($size != 0){			
					$store_vid= $responsevideo['campaigndetails'][0]['CampaignDetID']; 
					$uid= $responsevideo['campaigndetails'][0]['UserId']; //used for shopify
					$this->session->set_userdata('getuser',$uid);//used for shopify
					$this->session->set_userdata('Video_ID',$store_vid);
					
					$campaign['video']= $responsevideo;
					
					$image=$responsevideo['campaigndetails'][0]['WrapperPath'];
					$title=$responsevideo['campaigndetails'][0]['CampaignTitle'];
					$des=$responsevideo['campaigndetails'][0]['CampaignDesc'];
					$data['meta']=array('image'=>$image,'title'=>$title,'des'=>$des);
							
					$this->load->view('includes/header',$data);
					$this->load->view('includes/top-menu');
					$this->load->view('pages/paper-craft',$campaign);
					$this->load->view('includes/footer');
				}else{ 				
					redirect('Video_curl/campaign'); 
				}
		}
	}
	//IsCampaign= 0 refer this function
	public function video($videoID = 0)
	{
		if($videoID == 0){
			$front_url = FRONT_VIDEO."?UserId=1"; //Remove UserId=1 parameter
			$front_video = curl_init();
			curl_setopt($front_video, CURLOPT_URL, $front_url);
			curl_setopt($front_video, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($front_video, CURLOPT_PROXYPORT, 3128);
			curl_setopt($front_video, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($front_video, CURLOPT_SSL_VERIFYPEER, 0);
			$re_front = json_decode(curl_exec($front_video), true);
			curl_close($front_video);
			if(sizeof($re_front['videodetails']) > 0){
				$videoID =$re_front['videodetails'][0]['VideoID'];			
			}else{
				$videoID = 44;
			}
		}
		$iscampaign=0;
		$return=0;
		$Views= $this->session->userdata('ViewCount');
		if(!$this->session->userdata('ViewCount')){ 
			$return=$this->IncreaseCount($iscampaign,$videoID);
			$this->session->set_userdata('ViewCount',$videoID);
		}elseif($Views != $videoID){
			$return=$this->IncreaseCount($iscampaign,$videoID);
			$this->session->set_userdata('ViewCount',$videoID);
		}
		if($return == 0){ 
			$video_url = VIDEO_DETAIL."?isHome=1&isProfile=1&Count=10&PageNum=1&VideoID=".$videoID; //Remove UserId=53 parameter
			$video_data = curl_init();
			curl_setopt($video_data, CURLOPT_URL, $video_url);
			curl_setopt($video_data, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($video_data, CURLOPT_PROXYPORT, 3128);
			curl_setopt($video_data, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($video_data, CURLOPT_SSL_VERIFYPEER, 0);
			$responsevideo = json_decode(curl_exec($video_data), true);
			curl_close($video_data);		
						
			$size= sizeof($responsevideo['videodetails']);

			if($size != 0){
				
				$store_vid= $responsevideo['videodetails'][0]['VideoID']; 
				$this->session->set_userdata('Video_ID',$store_vid);
				$uid= $responsevideo['videodetails'][0]['UserID']; //used for shopify
				$this->session->set_userdata('getuser',$uid);//used for shopify	
				$video['video']= $responsevideo;
					$image=$responsevideo['videodetails'][0]['WrapperPath'];
					$title=$responsevideo['videodetails'][0]['Title'];
					$des=$responsevideo['videodetails'][0]['Description'];
					$data['meta']=array('image'=>$image,'title'=>$title,'des'=>$des);
				
					$this->load->view('includes/header',$data);
				
				$this->load->view('includes/top-menu');
				$this->load->view('pages/paper-craft',$video);
				$this->load->view('includes/footer');
			}else{ 
				redirect('Video_curl/video');		
			}
		}
	}
		
	// Collaborate function
	public function collaborate($CampaignDetID){
		$collaborate_url = DROPBOX_COLLABORATE."?CampaignDetID=".$CampaignDetID."&Count=5&PageNum=1";
        $collaborate_data = curl_init();
        curl_setopt($collaborate_data, CURLOPT_URL, $collaborate_url);
        curl_setopt($collaborate_data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($collaborate_data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($collaborate_data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($collaborate_data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_coll = json_decode(curl_exec($collaborate_data), true);
        curl_close($collaborate_data);
		$collaborates['collaborate_deatils']= $response_coll;
		
		$this->load->view('includes/header');	
		$this->load->view('includes/top-menu');		
		$this->load->view('pages/googledrive',$collaborates);
		$this->load->view('includes/footer');
		
	}
	public function comments_donors($CampaignDetID,$Video_ID,$active){	
		$this->session->set_userdata('active',$active);
		if(empty($this->session->userdata['iscampaign'])){
			$iscampaign = 0;
		}else{
			$iscampaign = $this->session->userdata['iscampaign'];
		}
		
		$comments_url = COMMENTS ."?VideoID=".$Video_ID."&CampaignDetID=".$CampaignDetID."&Count=25&PageNum=1";
        $comments_data = curl_init();
        curl_setopt($comments_data, CURLOPT_URL, $comments_url);
        curl_setopt($comments_data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($comments_data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($comments_data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($comments_data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_comment = json_decode(curl_exec($comments_data), true);
        curl_close($comments_data);
		$comments['comments_deatils']= $response_comment;
		//echo '<pre>';print_r($response_comment);
		
		$donor_url = DONORS ."?VideoID=".$Video_ID."&CampaignDetID=".$CampaignDetID."&Count=25&PageNum=1";
        $donor_data = curl_init();
        curl_setopt($donor_data, CURLOPT_URL, $donor_url);
        curl_setopt($donor_data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($donor_data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($donor_data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($donor_data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_donor = json_decode(curl_exec($donor_data), true);
        curl_close($donor_data);
		$donor['donor_deatils']= $response_donor;
		//echo '<pre>';print_r($response_donor);
		
	if($iscampaign == 1){ 
		$video_list_url = VIDEO_LIST ."?CampaignDetID=".$CampaignDetID."&Count=25&PageNum=1";
        $video_data = curl_init();
        curl_setopt($video_data, CURLOPT_URL, $video_list_url);
        curl_setopt($video_data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($video_data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($video_data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($video_data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_video = json_decode(curl_exec($video_data), true);
        curl_close($video_data);
		$video['video_deatils']= $response_video;
		//echo '<pre>';print_r($response_video);
		
		$act_list_url = ACTIVITY_LIST ."?VideoID=0&CampaignDetID=".$CampaignDetID."&Count=25&PageNum=1";
        $act_data = curl_init();
        curl_setopt($act_data, CURLOPT_URL, $act_list_url);
        curl_setopt($act_data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($act_data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($act_data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($act_data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_act = json_decode(curl_exec($act_data), true);
        curl_close($act_data);
		$act['activity_deatils']= $response_act;
		//echo '<pre>';print_r($response_act);
		$this->load->view('includes/header');	
		$this->load->view('includes/top-menu');		
		$this->load->view('pages/comment-donor',array_merge($comments,$donor,$video,$act));
		$this->load->view('includes/footer');
		
		}else{ 
			$uid=$this->session->userdata('getuser');
			$video_list_url = VIDEO ."?UserId=".$uid."&isHome=0&isProfile=0&Count=25&PageNum=1&FilterBy=";
			$video_data = curl_init();
			curl_setopt($video_data, CURLOPT_URL, $video_list_url);
			curl_setopt($video_data, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($video_data, CURLOPT_PROXYPORT, 3128);
			curl_setopt($video_data, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($video_data, CURLOPT_SSL_VERIFYPEER, 0);
			$response_video = json_decode(curl_exec($video_data), true);
			curl_close($video_data);
			$video['video_deatils']= $response_video;
			//echo '<pre>';
			//print_r($video);exit;
			$this->load->view('includes/header');	
			$this->load->view('includes/top-menu');		
			$this->load->view('pages/comment-donor',array_merge($comments,$donor,$video));
			$this->load->view('includes/footer');	
			
		}
	}
	
	public function IncreaseCount($iscampaign,$id){
		
		if (!empty($this->session->userdata['login_userdata'])){ 
			$userdata=$this->session->userdata('login_userdata');
			$userid= $userdata['UserID'];
		}else{
			$userid='0';
		}
		//echo '<pre>';
		if($iscampaign == 1){
			$iscampaign='true';
		}else{
			$iscampaign='false';
		}
		$creadtedonmobile=date('Y-m-d h:i:s');
		$DeviceId=round(microtime(true));
		$IsSync='false';
		
		$ViewCount = array('CreatedOn'=>$creadtedonmobile,
							   'CreatedOnMobile'=>$creadtedonmobile,
							   'DeviceID'=>$DeviceId,
							   'IsCampaign'=>$iscampaign,
							   'IsSync'=>$IsSync,
							   'UpdatedOn'=>$creadtedonmobile,
							   'UpdatedOnMobile'=>$creadtedonmobile,
							   'UserID'=>$userid,
							   'VideoID'=>$id,
							   'ViewedOn'=>$creadtedonmobile,
							   'ViewersID'=>$DeviceId
							   );
		$datajson['viewersdetails'][0] = $ViewCount;		   
		$data_string = json_encode($datajson);
//print_r($ViewCount);
		$url=SYNCTODB;     													
		$ch = curl_init();                              
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
				
		$response_data = curl_exec($ch);
		$return=curl_errno($ch);
		curl_close($ch);
		return $return;
		
	}
	public function activity_updates($videoID){
		
		$act_list_url = ACTIVITY ."?VideoID=".$videoID."&Count=10&PageNum=1";
        $act_data = curl_init();
        curl_setopt($act_data, CURLOPT_URL, $act_list_url);
        curl_setopt($act_data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($act_data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($act_data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($act_data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_act = json_decode(curl_exec($act_data), true);
        curl_close($act_data);
		$act['activity_deatils']= $response_act;
		//echo '<pre>';print_r($act);exit;
			$this->load->view('includes/header');	
			$this->load->view('includes/top-menu');		
			$this->load->view('pages/activity_updates',$act);
			$this->load->view('includes/footer');	
		
	}
}
?>