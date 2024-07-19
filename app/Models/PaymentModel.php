<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function save_transaction($data) {
        // Insert transaction data into database
        $this->db->insert('payments', $data);
        return $this->db->insert_id();
    }
}
?>
