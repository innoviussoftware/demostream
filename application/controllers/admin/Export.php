<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function subscription() {
        $filename = "subscription.csv";
        $fp = fopen('php://output', 'w');
        $header = array('NAME', 'SUBSCRIPTION DATE', 'SUBSCRPITION AMOUNT', 'INVOICE ID', 'FROM DATE', 'END DATE', 'ACCOUNT NAME', 'TRANSACTION ID');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        $num_column = count($header);
        $a = array('', '', '', '', '', '', '', '');
        fputcsv($fp, $a);
        $url = Subscriptionlist;
        $data = curl_init();
        curl_setopt($data, CURLOPT_URL, $url);
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data = json_decode(curl_exec($data), true);
        $return = curl_errno($data); //returns 0 if no errors occured
        curl_close($data);

        $detail = $response_data['subscription'];

        for ($j = 0; $j < sizeof($detail); $j++) {

            $data_report[$j]['name'] = $detail[$j]['FirstName'] . ' ' . $detail[$j]['LastName'];
            $data_report[$j]['SubscriptionDate'] = date('m/d/Y', strtotime($detail[$j]['SubscriptionDate']));
            $data_report[$j]['SubscriptionAmount'] = $detail[$j]['SubscriptionAmount'];
            $data_report[$j]['InvoiceId'] = $detail[$j]['InvoiceId'];
            $data_report[$j]['SubFromDate'] = date('m/d/Y', strtotime($detail[$j]['SubFromDate']));
            $data_report[$j]['SubEndDate'] = date('m/d/Y', strtotime($detail[$j]['SubEndDate']));
            $data_report[$j]['AccountName'] = $detail[$j]['AccountName'];
            $data_report[$j]['TransactionId'] = $detail[$j]['TransactionId'];

            fputcsv($fp, $data_report[$j]);
        }
//       
    }

}

?>
