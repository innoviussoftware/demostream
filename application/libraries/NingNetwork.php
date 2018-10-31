<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of NingNetwork
 *
 * @author wahyu widodo
 */
include("./vendor/autoload.php");

class NingNetwork {

    public function __construct(){
        $response = array(
            'error_code' => 1,
            'message' => "",
            'data' => array(),
        );
    }

    public function CreateNetwork($networkKey,$email,$name,$expiration_date)
    {

       $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => CREATE_NETWORK,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "apiLogin=".API_LOGIN."&apiPassword=".API_PASSWORD."&networkKey=".$networkKey."&email=".$email."&name=".$name."&profileName=".$name."&language=en_US&expirationDate=".$expiration_date ,
        CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"        
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->response['error_code'] = 1;
        } else {
            $data = json_decode($response);
            
            if(isset($data->errorCode) && $data->errorCode == '2'){
                $this->response['error_code'] = 1;
            }else{
                $this->response['error_code'] = 0;
                $this->response['data'] = $networkKey;
            }            
        }
        return $this->response;
    }

    public function CreateProductForNetwork($paywall_id, $product_key, $product_name,$network_key,$product_type) 
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => CREATE_PRODUCT_FOR_NETWORK,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN
            . "&apiPassword=" . API_PASSWORD . "&"
            . "networkKey=" . $network_key . "&"
            . "productKey=" . $product_key
            . "&name=" . $product_name . "&"
            . "url=".base_url()."&type=".$product_type,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response_ning = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->response['error_code'] = 1;
        } else {
            $response_ning_array = json_decode($response_ning);
            if(isset($response_ning_array->errorMsg)){
                $this->response['error_code'] = 1;
                $this->response['message'] = $response_ning_array->errorMsg;
                return $this->response;
            }
            if (isset($response_ning_array->productId) && $response_ning_array->productId != '') {
                $this->response['error_code'] = 0; 
                $this->response['data'] = $product_key;
            } else {
                $this->response['error_code'] = 1;
            }
        }
         return $this->response;
    }

    public function AddRelationBetweenProductKeyAndPayWall($paywall_id, $product_key,$network_key) 
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ADD_RELATION_BETWEEN_PRODUCTKEY_AND_PAYWALL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . "&"
            . "apiPassword=" . API_PASSWORD . "&"
            . "productKey=" . $product_key . "&"
            . "payWallId=" . $paywall_id . "&"
            . "networkKey=" . $network_key,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->response['error_code'] = 1;
        } else {
            $data = json_decode($response);
            if (isset($data->productPayWallRelationId) && $data->productPayWallRelationId != '') {
                $this->response['error_code'] = 0;
                $this->response['data'] = $data->productPayWallRelationId;
            } else {
               $this->response['error_code'] = 1;
            }
        }
         return $this->response;
    }

    public function GetOtpForNetwork($email,$network_key)
    {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => IFRAME_NING_PAYWALL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . "&apiPassword=" . API_PASSWORD . "&networkKey=".$network_key."&email=" . $email,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response_urls = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              $this->response['error_code'] = 1;
            } else {
                $iframe_ning_paywall = (array) json_decode($response_urls);
                if (count($iframe_ning_paywall) > 0 && !isset($iframe_ning_paywall['errorMsg'])) {
                    $url = $iframe_ning_paywall['otpLoginUrl'];                    
                    $this->response['data']=$url;
                    $this->response['error_code'] = 0; 
                } else {
                    $this->response['error_code'] = 1;                  
                }                
            }
            return $this->response;
    }

    public function GetPaywallList($network_key,$product_type)
    {
      $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => PAYWALL_LIST,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "apiLogin=" . API_LOGIN . "&apiPassword=" . API_PASSWORD . "&networkKey=" . $network_key. "&productType=".$product_type,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $paywalls = array();
        $paywalls = json_decode($response);
        if (count($paywalls) > 0) {
            $this->response['error_code'] = 0;
            $this->response['data']=$paywalls;
        } else {
            $this->response['error_code'] = 1;
        }
        return $this->response;
    }

}
?>
