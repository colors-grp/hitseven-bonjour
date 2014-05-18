<?php

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));

		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array('account/account_model', 'session_model', 'core_call'));
		$this->load->model(array('account/account_details_model'));
		$this->load->model(array('account/account_facebook_model'));
                $this->load->model('round_model');
                $this->load->model('category_model');
                $this->load->model('core_call');
                $this->load->model('scoreboard_model');

		// Facebook connections are banned from Platform ...

		//$this->load->model(array('account/account_facebook_model'));
		//$this->load->model(array('facebook_utils'));
	}

	function index()
	{

		maintain_ssl();

		$accountid = $this->input->get('accountid');
		$_SESSION['language'] = 'english';

		// If the user is signed in ...
		if ($this->authentication->is_signed_in())
		{
			log_message('error', 'signed in and back home !!! account id = '. $this->session->userdata('account_id'));
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			$data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
			// 			$data['friends'] = $this->core_call->getFacebookFriends($this->session->userdata('account_id'));

			$fb = $this->account_facebook_model->get_by_account_id($this->session->userdata('account_id'));

			$_SESSION['fb_id'] = $fb[0]->facebook_id;
			log_message('error', 'redirect 3la platform, FB ID = ' . $_SESSION['fb_id']);
			redirect('platform');
		}

		// This is true for redirections from Core ...
		if($accountid)
		{
			log_message('error', 'bevore Sign in acc id == '.$accountid);
			$this->authentication->sign_in($accountid);
		}
                // contains top 3 users for each category
        // Get homepage top 3 ranks with thier facebook IDs
            // Get all categories from db
                $result = $this->category_model->get_all_category()->result_array();
            // Get top 3 of every category from current scoreboards
                $data['scoreboard_home_view'] = $this->scoreboard_model->get_home_page_scoreboard($result);
            // Get Facebook IDs of all users from core db
                $users_ids = array();
                for($i=0;$i<count($data['scoreboard_home_view']);$i++){
                    for($j=0;$j<count($data['scoreboard_home_view'][$i]['data']);$j++){
                        array_push($users_ids, $data['scoreboard_home_view'][$i]['data'][$j]->user_id);
                    }
                }
                //log_message('error','mo7eb home index $users_ids='.  print_r($users_ids,TRUE));
                $fb_ids = $this->core_call->getFacebookIDs($users_ids);
                $pos = 0;
                for($i=0;$i<count($data['scoreboard_home_view']);$i++){
                    for($j=0;$j<count($data['scoreboard_home_view'][$i]['data']);$j++,$pos++){
                        $data['scoreboard_home_view'][$i]['data'][$j]->fb_id = $fb_ids[$pos];
                    }
                }
                //log_message('error','mo7eb home index $fb_ids='.  print_r($fb_ids,TRUE));
                //get categories (SORTED)
		$data['sorted_cats'] = $this->scoreboard_model->get_sorted_cats();
                //Loading the current round data
		log_message('error','mo7eb home index() $sitecode='.$this->config->item('sitecode'));
                $data['rounds'] = $this->round_model->getCurrentRound($this->config->item('sitecode'));
                if($data['rounds'] != FALSE)
                    $data['rounds'] = $this->round_model->getCurrentRound($this->config->item('sitecode'))->result();
		//gonna load the home view anyway ! ...
		$this->load->view('home_view', $data);
	}

}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */