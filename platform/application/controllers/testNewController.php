<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class TestNewController extends CI_Controller {
    public function __construct() {
		parent::__construct ();
		// Load needed models
		$this->load->model('category_model');
		$this->load->model ( 'scoreboard_model' );
                $this->load->model('round_model');

		//Load credit helper
		$this->load->helper('credit');
                $this->load->helper('account');
                

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));

		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array('account/account_model', 'session_model', 'core_call'));
		$this->load->model(array('account/account_details_model'));
		$this->load->model(array('account/account_facebook_model'));

	}
    function index(){
        //Load view
        $this->load->view('pages/testNewView');
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

