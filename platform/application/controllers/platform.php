<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Platform extends CI_Controller {
	protected $CI;
	function __construct() {
		parent::__construct();
		$this->CI =& get_instance();

		// This is a new comment 
		// Load models ...
		$this->load->model('core_call');
		$this->load->model('competition_model');
		$this->load->model('category_model');
		$this->load->model('card_model');
		$this->load->model('user_model');
                $this->load->model ( 'scoreboard_model' );

		//Load credit helper
		$this->load->helper('credit');
		
		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
		
		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array('account/account_model', 'session_model', 'core_call'));
		$this->load->model(array('account/account_details_model'));
		$this->load->model(array('account/account_facebook_model'));
		
		//Start session if it is not already started
		if (session_id() == '')
			session_start();
	}

	//A function that returns the Id and name of first category
	function get_first_category_info($interest_categories) {
		if($interest_categories != FALSE) {
			$cat_info = $interest_categories->row();
			$info['id'] =  $cat_info->id;
			$info['name'] = $cat_info->name;
			return $info;
		}
	}

	// A function that returns categories user not interseted in
	// given all categories and categories user interseted in
	function get_not_interst_categories($all_categories , $interest_categories) {
		$res = array();
		foreach ($all_categories->result() as $row) {
			$int = $interest_categories;
			$to_add = 1;
			if($int != false) {
				foreach ($int->result() as $row2)
					if($row->id == $row2->id)
					$to_add = 0;
			}

			if($to_add == 1)
				array_push($res , $row);
		}
		return $res;
	}

	// A controller proxy to helper functions needed from JavaScript ...
	function buy_credit()
	{
		buy_credit();
	}

	function buy_card()
	{
		$user_id = get_user_id();
		$result = buy_card($user_id);
                log_message('error','mo7eb platform buy_card $result='.  print_r($result,TRUE));
                echo $result;
	}

	// Get user ID ... Currently set to return a dummy value for testing ...
	function get_dashboard_info($user_id, $interset_cats) {
		if (!$interset_cats)
			return FALSE;
		$result = array();
		$i = 0;
		foreach ($interset_cats->result() as $int_cat) {
                    $viewLimit = 3; // number must be odd cuz the cur_user will be in middel
                    $cat_name = $this->category_model->get_category_name_by_id($int_cat->id);
                    $cur_rank = $this->scoreboard_model->get_user_rank($user_id, $cat_name)->row(0)->rank;
                    $total_scores = $this->scoreboard_model->get_total_scores($cat_name)->row(0)->total;
                    $difference = 1;
                    if($cur_rank == 1){
                        $difference = 0;
                    }
                    else if($cur_rank == $total_scores){
                        $difference = 2;
                    }
                    $result[$i]['users'] = $this->scoreboard_model->get_dash_ranks($user_id, $cat_name, $difference, $viewLimit);
                    $result[$i]['cat_id'] = $int_cat->id;
                    $result[$i]['cat_name'] = $int_cat->name;
                    $result[$i]['pos'] = $difference;
                    $i ++;
		}
                return FALSE;
	}

	// Entry point for Platform ...
	function index() {
		if (!$this->authentication->is_signed_in() || !isset($_SESSION['fb_id'])) {
			redirect('home');
		} else {
                        /*if (!isset($_SESSION['fb_id']) || $_SESSION['fb_id'] == FALSE) {
                                    redirect('platform');
                        }*/
			$user_id = $_SESSION['user_id'] = $this->session->userdata('account_id');
			$comp_id = $_SESSION['competition_id'] = get_competition_id();
			log_message('error','Mo7eb >>>> $user_id='.$user_id.' SESSION='.$_SESSION['user_id'].' thisSession='.$this->session->userdata('account_id'));
			$dates = get_start_end_dates($comp_id);
			$data['main_view']['start_date'] = to_time_stamp($dates['start']);
			$data['main_view']['end_date'] = to_time_stamp($dates['end']);
			$data['page'] = 'main_view';
			$data['header_view']['page'] = 'main_view';
			// temporary hard coded ...
			$me = $this->core_call->getMe($this->session->userdata('account_id'));
			$data['header_view']['name'] = $me->fullname;
			$data['main_view']['name'] = $me->fullname;
			// check whether the user is admin or not
			$user_type = get_user_type();
			$data['header_view']['is_admin'] = ($user_type == 'admin' ? true : false);
			$_SESSION['user_id'] = $data['header_view']['user_id'] = $data['main_view']['user_id'] = $user_id;

			// Get user credit ...
			$data['main_view']['user_points'] = get_credit();
                        //$data['main_view']['user_points'] = 0;
                        log_message('error','mo7eb platform index $user_points='.$data['main_view']['user_points']);

			// Get User favorite categories ...
			$interset_cats = $data['main_view']['interest_cats'] = $this->category_model->get_category_interst_by_userID($user_id);
                        // Get dashboard
                        $dashResult = $this->get_dashboard_info($user_id, $interset_cats);
                        if($dashResult == FALSE){
                            $data['main_view']['dashboard'] = FALSE;
                        } else {
                            $data['main_view']['dashboard'] = $this->get_dashboard_info($user_id, $interset_cats);
                        }
                        // Get round dashboard info
                        $this->load->model('round_model');
                        $_SESSION['cur_round'] = $this->round_model->getCurrentRound($this->config->item('sitecode'));
                        if($_SESSION['cur_round'] != FALSE){
                            $_SESSION['cur_round'] = $_SESSION['cur_round']->row(0);
                        }

			// Get all categories ...
			$all_categories = $this->category_model->get_all_category();

			// Calculate which categories are not in Favorite panel ...
			$data['main_view']['not_interest_cats'] = $this->get_not_interst_categories($all_categories , $data['main_view']['interest_cats']);

			// Set the currently selected Category
			if(!isset($_SESSION['current_category_id'] )) {
				//Get first category info to be set in the session array
				$first_cat = $this->get_first_category_info($data['main_view']['interest_cats']);

				//Set first category ID and name only if they aren't already in session
				$_SESSION['current_category_id'] = $first_cat['id'];
				$_SESSION['current_category_name'] = $first_cat['name'];
			}
			$data['main_view']['cat_id'] = $_SESSION['current_category_id'];
			$data['main_view']['cat_name'] = $_SESSION['current_category_name'];
			$user_id = get_user_id();
			//Set session data
			$_SESSION['user_id']= $user_id;
			$data['fb_id'] = $_SESSION['fb_id'];
			$_SESSION['card_view'] = 'list';
			$_SESSION['current_page'] = 'market';


			//Load the template view
			$this->load->view('template', $data);
		}
	}
}