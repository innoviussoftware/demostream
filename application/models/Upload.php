<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function do_upload($data) {
        ini_set("upload_max_filesize", "300M");
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|mp4';
        //$config['max_size'] = '500M';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($data)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }

    public function do_upload_multiple($files, $count) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|txt|pdf|doc|docx|xls|xlsx';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        for ($i = 0; $i < $count; $i++) {
            $_FILES['userfile']['name'] = $files['name'][$i];
            $_FILES['userfile']['type'] = $files['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['error'][$i];
            $_FILES['userfile']['size'] = $files['size'][$i];

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                return $error;
            } else {
                $data[] = array('upload_data' => $this->upload->data());
            }
            // print_r($error);exit;
        }

        return $data;
    }

    public function do_upload_logo($data) {

        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($data)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }

    public function do_upload_banner($files, $count, $UserID) {
        $config['upload_path'] = './uploads/banner/' . $UserID . '/';
        $config['allowed_types'] = 'gif|jpg|png|txt|pdf|doc|docx|xls|xlsx';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        for ($i = 0; $i < $count; $i++) {
            $_FILES['userfile']['name'] = $files['name'][$i];
            $_FILES['userfile']['type'] = $files['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['error'][$i];
            $_FILES['userfile']['size'] = $files['size'][$i];

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                return $error;
            } else {
                $data[] = array('upload_data' => $this->upload->data());
            }
            // print_r($error);exit;
        }

        return $data;
    }

    public function do_upload_profile($data) {
        ini_set("upload_max_filesize", "300M");
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //$config['max_size'] = '500M';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($data)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }

    public function do_upload_with_folder($data, $folder) {
        ini_set("upload_max_filesize", "300M");
        $config['upload_path'] = './' . $folder . '/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //$config['max_size'] = '500M';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($data)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }

}
