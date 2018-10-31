<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Stripegateway
 *
 * @author wahyu widodo
 */
include("./vendor/autoload.php");

class Stripegateway {

    public function __construct() {
        
    }

    public function checkout($data, $stripe) {
         \Stripe\Stripe::setApiKey($stripe['secret_key']);

    //  \Stripe\Stripe::setApiKey('sk_test_BXg8CAB9wtNTm1lNBe3HMK2X');
  //   print_r($data);exit;
        $message = "";

        try {
            $token = \Stripe\Token::create(
                            array(
                                "card" => array(
                                    "number" => base64_decode($data['number']),
                                    "exp_month" => $data['exp_month'],
                                    "exp_year" => $data['exp_year'],
                                    "cvc" => base64_decode($data['cvc'])
                                )
                            )
            );
//            $mycard = array('number' => $data['number'],
//                'exp_month' => $data['exp_month'],
//                'exp_year' => $data['exp_year']);
            //print_r($data);

            $charge = \Stripe\Charge::create(array('source' => $token,
                        'amount' => $data['amount'],
                        'currency' => 'usd'));
            //$charge->id;
            // echo '<pre>';            var_dump($charge);exit;
            $message = $charge->id;
        } catch (Exception $e) {
            //$message = $e->getMessage();
             $message = 1;
        }

        return $message;
    }

    public function admin_checkout($data, $stripe) {

        \Stripe\Stripe::setApiKey('sk_test_SWtrR1X9Tax5G9V4wlCtjoVy');
        //print_r($data);
        $message = "";

        try {
            $mycard = array('number' => $data['number'],
                'exp_month' => $data['exp_month'],
                'exp_year' => $data['exp_year']);
            //print_r($data);

            $charge = \Stripe\Charge::create(array('source' => 'tok_visa',
                        'amount' => $data['amount'],
                        'currency' => 'usd'));
            $message = $charge->id;
        } catch (Exception $e) {
            //$message = $e->getMessage();
            $message = 1;
        }
        //return $message;
        return $message;
    }

}
