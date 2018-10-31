<?php

class Facebook_model extends CI_Model {

    public function facebook() {
        $city = $this->db->get('city')->result();
        return $city;
    }
}