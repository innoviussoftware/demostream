<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hauth Controller Class
 */
class Hauth extends CI_Controller {

    /**
     * {@inheritdoc}
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('hybridauth');
        $this->load->library('session');
    }

    /**
     * {@inheritdoc}
     */
    public function users($type = 'login-page') {
        // Build a list of enabled providers.
        $providers = array();
        foreach ($this->hybridauth->HA->getProviders() as $provider_id => $params) {
            $providers[] = anchor("hauth/window/{$provider_id}", $provider_id);
        }
        if (empty($this->session->userdata['login_userdata'])) {
            $this->load->view('includes/header');
            $this->load->view('includes/top-menu');
            $this->load->view('pages/' . $type, array('providers' => $providers));
            $this->load->view('includes/footer');
        } else {
            redirect('Video_curl/video');
        }

//        $this->load->view('hauth/login_widget', array(
//            'providers' => $providers,
//        ));
    }

    /**
     * Try to authenticate the user with a given provider
     *
     * @param string $provider_id Define provider to login
     */
    public function window($provider_id) {
        $type = 0;
        $params = array(
//            'hauth_return_to' => site_url("hauth/window/{$provider_id}"),
            'hauth_return_to' => base_url() . "hauth/window/$provider_id",
        );
        if (isset($_REQUEST['openid_identifier'])) {
            $params['openid_identifier'] = $_REQUEST['openid_identifier'];
        }
        try {
            $adapter = $this->hybridauth->HA->authenticate($provider_id, $params);

            $profile = $adapter->getUserProfile();

            //print_r($adapter);exit;
            $my_array = json_encode($profile, true);
            $my_profile = json_decode($my_array, true);

            //	echo $provider_id;
            if ($provider_id == 'Facebook') {
                $type = 1;
            } elseif ($provider_id == 'Google') {
                $type = 2;
            } elseif ($provider_id == 'Twitter') {
                $type = 3;
            } else {
                $type = 0;
            }
            $profiles = array('profile' => $my_profile);

            $this->session->set_userdata('profile_data', $profiles);
            redirect('Users/register/' . $type);

//            redirect('/hauth', redirect);           
//			$this->load->view('hauth/done', array(
            //          'profile' => $profile,
            //    ));
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
    }

    /**
     * Handle the OpenID and OAuth endpoint
     */
    public function endpoint() {
        $this->hybridauth->process();
    }

    function share($url, $arr) {
        $this->load->helper('share');
        $this->load->view('share/index');
    }

    public function facebook_login() {
        $response = $this->facebook->request('736600566548111', '105bfe73fc8087dbf5016ed1fe7224d1');
    }

    public function facebook_success() {
        $code = $_REQUEST['code'];

        $graphObj = $this->facebook->response('736600566548111', '105bfe73fc8087dbf5016ed1fe7224d1', $code);

        $profile = array('profile' => $graphObj);
        $this->session->set_userdata('profile_data', $profile);
        redirect('Users/register/1');
    }
    
    
    public function redirect() {
        
        $val = $this->input->post('value');
        $this->session->set_userdata('redirect', $val);
        echo base_url() . 'Hauth/users';
    }

    public function redirection() {
        $val = $this->input->post('value');
        $vid = $this->input->post('vid');
        $uid = $this->input->post('uid');

        $this->session->unset_userdata('redirect');
        $this->session->unset_userdata('vid');
        $this->session->unset_userdata('uid');
    
        $this->session->set_userdata('redirect', $val);
        $this->session->set_userdata('vid', $vid);
        $this->session->set_userdata('uid', $uid);
        echo base_url() . 'Hauth/users';
    }

}

?>