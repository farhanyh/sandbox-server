<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->user_table = 'users';
    }

    public function get_rows($params = array()) {
        $this->db->select('*');
        $this->db->from($this->user_table);

        // fetch data by conditions
        if (array_key_exists('conditions', $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        if (array_key_exists('username', $params)) {
            $this->db->where('username', $params['username']);
            $query = $this->db->get();
            $result = $query->row_array();
        }
        else {
            if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
                $this->db->limit($params['limit'], $params['start']);
            }
            elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
                $this->db->limit($params['limit']);
            }

            if (array_key_exists('return_type', $params) && $params['return_type'] == 'count') {
                $result = $this->db->count_all_results();
            }
            elseif (array_key_exists('return_type', $params) && $params['return_type'] == 'single') {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->row_array() : false;
            }
            else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : false;
            }
        }

        return $result;
    }

    public function insert($data) {
        if (!array_key_exists('created', $data)) {
            $data['created'] = date('Y-m-d H:i:s');
        }
        if (!array_key_exists('modified', $data)) {
            $data['modified'] = date('Y-m-d H:i:s');
        }

        $insert = $this->db->insert($this->user_table, $data);
    }
}