<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('email');
    }

    public function submit() {
        if ($this->input->post('submit') != '') {
        $config = Array(
            'protocol' => 'sendmail',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'bcc_batch_mode' => TRUE,
            'bcc_batch_size' => 300
        );
        $name = '';
        $email = '';
        $phone = '';
        $body = '';
        if ($this->input->post('name') != '') {
            $name = $this->input->post('name');
        }if ($this->input->post('email') != '') {
            $email = $this->input->post('email');
        }if ($this->input->post('phone') != '') {
            $phone = $this->input->post('phone');
        }if ($this->input->post('message') != '') {
            $body = $this->input->post('message');
        }

if($name != '' && $email != '' && $phone != '' && $body != ''){
        $mailto = CONTACT_EMAIL;
        //$mailto = 'jinal.innovius@gmail.com';   
        $subject = 'Demostream | Website';

        // $body = "Name : $name<br>Email : $email<br>Phone : $phone<br>Message : $message";

        $message = '<html><body>';
        $message .= '<b>Hello Admin, <br>You have received a new message from the join demostream form on your website.</b><br><br>';
        $message .= '<table>';
        $message .= '<tr><td><b>Name :</b></td><td>' . $name . '</td></tr>';
        $message .= '<tr><td><b>Email :</b></td><td>' . $email . '</td></tr>';
        $message .= '<tr><td><b>Phone :</b></td><td>' . $phone . '</td></tr>';
        $message .= '<tr><td><b>Message :</b></td><td>' . $body . '</td></tr>';
        $message .= '</table><br><br><br>Thank You<br>website: http://demostream.tv<br><br>';
        $message .= '</body></html>';

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(FROM_MAIL, 'Demostream | website');
      $this->email->to($mailto);
      //  $this->email->bcc('harshal@innoviussoftware.com');
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        $this->email->print_debugger();


      //  $success = mail($mailto, $subject, $message, $headers);
        

       
    $UserId = round(microtime(true));
        $DeviceID = round(microtime(true));
        $domain = '';
        $FirstName = $name;
        $LastName = '';
        $emailid = $email;
        $password = '';
        $city = '';
        $State = '';
        $Country = '';
        $website = '';
        $userfile = '';
        $account_name = $name;
        $sub_charge = 0;
        $transaction_share = 0;
        $VideoPurchaseShare = 0;


        $data1 = array(
            "ProfileID" => 0,
            "UserID" => 0,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "Region" => '',
            "City" => $city,
            "State" => $State,
            "Country" => $Country,
            "ProfilePICPath" => '',
            "DeviceID" => $DeviceID,
            "CreatedOnMobile" => date('Y-m-d h:i:s'),
            "CreatedOn" => date('Y-m-d h:i:s'),
            "UpdatedOnMobile" => date('Y-m-d h:i:s'),
            "UpdatedOn" => date('Y-m-d h:i:s'),
            "MobileRowOrderNo" => 0,
            "AccountName" => $account_name,
            "EmailID" => $emailid,
            "Password" => $password,
            "IsSignWithSocialMedia" => '',
            "IsAdmin" => 'false',
            "SubscriptionCharges" => $sub_charge,
            "TransactionShare" => $transaction_share,
            "VideoPurchaseShare" => $VideoPurchaseShare,
            "Website" => $website,
            "Logo" => '',
            "Domain" => $domain,
            "MobileNo" => $phone,
             "IsSuperAdmin" => 'false',
        );

        $datajson1['userprofiledetails'][0] = $data1;
        $data_string1 = json_encode($datajson1);
        $data_string1 = str_replace("\\/", "/", $data_string1);
        //exit;
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
        }
        $this->session->set_flashdata('data_msg', 'Thanks for your interest, Our team will contact you soon.');

        $vid = $this->session->userdata('Video_ID');

        redirect(base_url());
        }
        //redirect('Video_curl/campaign/' . $vid);
    }

}
