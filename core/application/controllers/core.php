<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		$this->load->library(array('account/authentication', 'account/authorization', 'account/facebook_lib'));
		$this->load->model(array('account/account_model', 'account/account_facebook_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}



	//Loading competition pictures
	public function load_competitions($account_id) {
		$this->load->model('home_model');
		$query['site_info'] = $this->home_model->get_competitions(); //getting current competitions information
		$query['user_id'] = $account_id;
		$this->load->view('home_view' , $query);
	}

	// This method should get the code from platform, and evaluate it to a URL from the HitSeven Database ...
	function getSiteUrl($sitecode)
	{
		if($sitecode == '1')
			return 'http://gloryette.co/heba';
	}

	function get_login_url() {
		// Set the redirect URL which facebook will return to after logging in ...
		// base_url (is the URL of the CORE -> send you to Core.php.index())
		$redirect_uri = base_url();
		// get the login url from facebook with the configured return uri
		return $loginurl = $this->facebook->getLoginUrl(array('redirect_uri' => "$redirect_uri", 'scope' => 'email,read_friendlists'));
	}

	function set_competitions_array($sites , $user_competitions) {
		//given all the competitions and competitions a certain user is enrolled in
		//it returns an array with competitions the user is enrolled in set to true
		//all other competitions are set to false
		foreach ($sites->result() as $site) {
			$tmp[$site->id] = false;
		}
		if($user_competitions!= FALSE) {
			foreach ($user_competitions as $comp) {
				//set the competitions the user is registered in to true,others are false
				$tmp[$comp->competition_id] = true;
			}
		}
		return $tmp;
	}

	function set_data_array($tmp , $user_name , $sites) {
		//prepares data array to be sent to view
		$data['check'] = $tmp;
		$data['username'] = $user_name;
		$data['site_info'] = $sites;
		return $data;
	}


	// Core is called via : http://www.colors-studios.com/core"
	// NOTE 24MARCH: The below is Khairy's index method ... to be migrated ...
	/*
	function index() {

	// Load fb utils ...

	// we pass this parameter to test the Rest controllers
	$rest = $this->input->get('rest');

	// Sidecode is a numerical value that represent the site primary ID in Database
	// Replacing encryption of the HTTP URL with a numerical value to avoid creating invalid characters in URL ...
	$sitecode = $this->input->get('sitecode');

	// if site code exists, means that the caller is Facebook ...
	if($sitecode) // This means it is a self-redirect that was configured in h7fb ...
	{
	// get user from facebook..
	$this->load->model('core_fbutils');

	$user_data = $this->core_fbutils->get_user();

	$platform_url = $this->getSiteUrl($sitecode);

	if ($user_data['is_true']) {

	// Set the session variables with Facebook information ...
	$this->session->set_userdata(array('facebook_uid' => $user_data['facebook_uid'], 'is_logged_in' => TRUE));
		
	// Get facebook access token
	$access_token = $this->core_fbutils->get_access_token();

	$fb_uid = $user_data['facebook_uid'];

	// Set the Platform URL again to redirect to Platform ...
	// "http://www.colors-grp.com/test1/?token= access_token . &fbuid= .$fbuid . "&core=1 ...
	$site_url = $platform_url . "?token=" .$access_token['access_token'] . "&fbuid=" .$fb_uid . "&core=" ."1";

	// redirect back to platform with configured parameters ...
	redirect($site_url);
	}
	else
	{
	$site_url = $platform_url . "?token=" .$access_token['access_token'] . "&fbuid=" .$fb_uid . "&core=" ."1";

	echo 'The URL is INVALID, Please check: ' . $site_url;
	}
	}
	else {

	$result = $this->core_fbutils->get_user();
	//user is logged in facebook
	if ($result['is_true']) {
	$this->session->set_userdata(array('facebook_uid' => $result['facebook_uid'], 'is_logged_in' => TRUE));
	//load user and competition model to deal with their database tables
	$this->load->model('user_model');
	$this->load->model('competition_model');

	//get user data using his facbook id
	$users_data = $this->user_model->get_user_by_fbid($result['facebook_uid']);

	//user is in database and logged on facebook
	if($users_data!= FALSE) {
	// set user's info for use in the view
	$user_id = $users_data->id;
	$user_name = $users_data->name;
	}else { //user is not in the database, but logged on facebook
	//get user information from facebook
	$me = $this->facebook->api('/me');
	$user_info['name'] = $me['name'];
	$user_info['fb_id']=  $me['id'];

	//add user to the data base
	$this->user_model->set_user($user_info);
	// set user's info for use in the view
	$user_id =$user_info['fb_id'];
	$user_name = $user_info['name'];
	}

	//get the competitions the user is enrolled in
	$user_competitions = $this->competition_model->get_competition_by_user_id($user_id);

	//get all competitions in hit7
	$sites = $this->competition_model->get_all_competition();

	//get array with user competitions set to true , others are set to false ... to be used in the view ...
	$tmp = $this->set_competitions_array($sites ,$user_competitions);

	//prepare info to be sent to the view
	$data = $this->set_data_array($tmp , $user_name , $sites);

	//load hitseven home view
	$this->load->view('pages/hit7home_view' , $data);
	} else { //user is not logged in facebook
	$this->load->model('competition_model');
	//get all competitions in hit7
	$data['site_info'] = $this->competition_model->get_all_competition();

	//get login url from facebook
	$data['login_url'] = $this->get_login_url();

	//load login view
	$this->load->view('pages/login_view' , $data);
	}

	}
	}*/

	// The sign-in supported index method ...
	// Core is called via : http://www.colors-studios.com/core"
	function index() {

		$cnt = 0;
		//Start session if it is not already started
		if (session_id() == '')
			session_start();

		// Sidecode is a numerical value that represent the site primary ID in Database
		// Replacing encryption of the HTTP URL with a numerical value to avoid creating invalid characters in URL ...
		$sitecode = $this->input->get('sitecode');
		$mode = $this->input->get('mode');
		$accountid = $this->input->get('accountid');
		$code = $this->input->get('code');

		// Load fb utils ...
		log_message('error', 'core.php: Site Code: '.$sitecode);
		log_message('error', 'core.php: Mode : '.$mode);

		// Platform sends a mode parameter = "signin" ...
		// As now we only support Facebook Login, this code redirects to check Facebook login ...
		if($mode == 'signin')
		{
				
			$cnt ++;
			log_message('error', 'core.php: mode ====== sign in : '.$mode);
			$_SESSION['sitecode'] = $sitecode;
			log_message('error', 'Added site code to session, redirecting to redirect_fb');
			// Load facebook redirect view
			redirect('account/redirect_fb');
		}

		// Handle a redirect coming from Facebook ...
		if($code){
			$cnt ++;
			log_message('error', 'Code parameter is here, this is a redirect from Facebook ...');
			log_message('error', 'Still have the site code !! ?? = ' .$_SESSION['sitecode']);

			// For an unknown reason, the redirection back to redirect_fb do not preserve FB login ...
			// Here loading the Facebook UID after redirection from Facebook for no good reason ...
			$facebook = new Facebook(array(
					'appId' => '170161316509571',
					'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
					'cookie' =>true
			));

			log_message('error', 'Trying to get facebook ID from core.php ...');

			// Try to get a logged in facebook user ID ...
			$session = $facebook->getUser();

			log_message('error', 'facebook user id from core.php : ' . $session);

			// Load facebook redirect view ... When we redirect here, the User ID is obtained successfully in redirect_fb
			redirect('account/redirect_fb');
		}

		// Handle a redirect from Core (create_connect, or else) ...
		if($this->authentication->is_signed_in())
		{
			$cnt ++;
			if($this->session->userdata('account_id'))
			{
				log_message('error', 'connect_create sent back to Core account id = ' .$this->session->userdata('account_id'));
			}
			else
			{
				log_message('error', 'connect_create sent back to Core  and cannot get account ID');
			}
			// Redirect to Platform with account ID parameter ...
			$redirect_url =  $this->authentication->getSiteUrl($_SESSION['sitecode']). '?accountid='.$this->session->userdata('account_id');
			redirect($redirect_url);
		}
			
		// This is a call from redirect_fb
		if($accountid)
		{
			log_message('error', 'redirect_fb sent back to Core account id = ' .$accountid);
			// Redirect to Platform with account ID parameter ...
			$redirect_url =  $this->getSiteUrl($sitecode). '?accountid='.$accountid;
			redirect($redirect_url);
		}
		if ($cnt == 0)
			$this->load_competitions($this->input->get('accountid'));
	}

	function logout() {
		$this->auth->logout();
	}

}