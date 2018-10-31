<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopify extends CI_Controller {

	public function __construct() {
        parent::__construct();	
		$this->load->helper('url');			
		$this->load->library('session');			
	}
	
	public function index()
	{		
		$uid=$this->session->userdata['getuser'];
		$Video_ID=$this->session->userdata['Video_ID'];
		$iscampaign=$this->session->userdata['iscampaign'];

		$url=FUND_MANAGER.'?UserID='.$uid.'&Count=5&PageNum=1';     													
		$ch = curl_init();                              
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response_data = json_decode(curl_exec($ch), true);
				
		curl_close($ch);
		$shopify_api=$response_data['fundmanager'][0];
		
		$API_KEY = $shopify_api['APIKeyToken'];		
		$PASSWORD= $shopify_api['APIKeyPassword'];		
		$STORE_URL = $shopify_api['ShopifyStoreName'].'.myshopify.com';
		//Modify these
		/*$API_KEY = SHOPIFY_API_KEY;		
		$PASSWORD= SHOPIFY_PASSWORD;
		$STORE_URL = SHOPIFY_STORE_NAME;*/
		
		//$SECRET = 'ad1b271fff14485d6a40ea8946b74701';
		//$TOKEN = 'bec938f9698264d95cc79daeaf3b76e9';	
		$url1='';
		$url1 = 'https://' . $API_KEY . ':' . $PASSWORD . '@' . $STORE_URL . '/admin/products.json';

		$data1 = curl_init();  
		curl_setopt($data1, CURLOPT_URL, $url1);
		curl_setopt($data1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data1, CURLOPT_PROXYPORT, 3128);
		curl_setopt($data1, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($data1, CURLOPT_SSL_VERIFYPEER, 0);
		$response_data1 = json_decode(curl_exec($data1), true);
		//curl_errno($data); //returns 0 if no errors occured
		curl_close($data1);
		
		/*if(sizeof($response_data['errors'])>0){
			 if($iscampaign == 1){
			 redirect('Video_curl/campaign/'.$Video_ID); 
			 }
			 else{ 
			 redirect('Video_curl/video/'.$Video_ID); 
			 }
		}else
		*/	
		$products=array();
		//$response_data=array();
		if(isset($response_data1['products'])){ 
		if(sizeof($response_data1) > 0){ 
		$this->session->set_userdata('shop_url',$STORE_URL);
		//echo '<pre>';
		//print_r($response_data1);exit;
			$products['product_list']=$response_data1['products'];
			$this->load->view('includes/header');
			$this->load->view('includes/top-menu');
			$this->load->view('pages/products',$products);
			$this->load->view('includes/footer');		
		}}else{
			
			$response_data1=array();
			$this->load->view('includes/header');
		$this->load->view('includes/top-menu');
		$this->load->view('pages/products',$products);
		$this->load->view('includes/footer');
		}
		
		
		
	}
	public function product_detail($id){
		$product['product_detail']=$this->session->userdata['product_detail'.$id];
		//echo '<pre>';print_r($product);				
		$this->load->view('includes/header');
		$this->load->view('includes/top-menu');
		$this->load->view('pages/product-detail',$product);
		$this->load->view('includes/footer');
		
	}
}
?>