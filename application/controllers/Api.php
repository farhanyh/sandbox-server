<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function user_get() {
        $r = $this->user_model->read();
        $this->response($r); 
    }

    public function user_put() {
        $id = $this->uri->segment(3);

        $data = array('username' => $this->input->get('username'),
            'password' => md5($this->input->get('password'))
        );

        $r = $this->user_model->update($id, $data);
        $this->response($r);
    }
}