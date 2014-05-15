<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_facebook_model extends CI_Model {
	
	//function is formatted for the following
	
	//https://graph.facebook.com/ID/CONNECTION_TYPE?access_token=123456
	// Use this method to get data from Facebook ...
	function get_facebook_object($object, $facebook_uid, $access_token) {
	
		$fb_connect = curl_init();
	
		curl_setopt($fb_connect, CURLOPT_URL, 'https://graph.facebook.com/'.$facebook_uid.'/'.$object.'?access_token='.$access_token);
	
		curl_setopt($fb_connect, CURLOPT_RETURNTRANSFER, 1);
	
		$output = curl_exec($fb_connect);
	
		curl_close($fb_connect);
	
		$result = json_decode($output);
	
		if (isset($result->error)) {
	
			$data['is_true'] = FALSE;
	
			$data['message'] = $result->error->message;
	
			$data['type'] = $result->error->type;
	
			$data['code'] = $result->error->code;
	
			return $data;
	
		} else {
	
			$data['is_true'] = TRUE;
	
			$data['data'] = $result->data;

			return $data;
		}
	}
	
	//example function
	
	function email($facebook_id, $token) {
	
		$result = $this->get_facebook_object('email', $facebook_id, $token);
	
		if ($result['is_true']) {
	
			$data['email'] = $result['data'];
	
		} else {
	
			$data['error_message'] = $result['message'];
			$data['error_code'] = $result['code'];
			$data['error_type'] = $result['type'];
	
			$data['email'] = array();
	
		}
	
		return $data;
	
	}
	
	//example function
	
	function friends($facebook_id, $token) {
	
		$result = $this->get_facebook_object('friends', $facebook_id, $token);
	
		log_message('error', 'account__FB__Model: going to get friends of ID: '.$facebook_id . '   with token: '.$token);
		
		if ($result['is_true']) {
	
			$data['friends'] = $result['data'];
	
		} else {
	
			$data['error_message'] = $result['message'];
			$data['error_code'] = $result['code'];
			$data['error_type'] = $result['type'];
	
			$data['friends'] = array();
	
		}
	
		return $data;
	
	}

	/**
	 * Get account facebook
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account facebook
	 */
	function get_by_account_id($account_id)
	{
		return $this->db->get_where('a3m_account_facebook', array('account_id' => $account_id))->result();
	}

	// --------------------------------------------------------------------

	/**
	 * Get account facebook
	 *
	 * @access public
	 * @param string $facebook_id
	 * @return object account facebook
	 */
	function get_by_facebook_id($facebook_id)
	{
		return $this->db->get_where('a3m_account_facebook', array('facebook_id' => $facebook_id))->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Insert account facebook
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $facebook_id
	 * @return void
	 */
	function insert($account_id, $facebook_id, $token)
	{
		$this->load->helper('date');

		if ( ! $this->get_by_facebook_id($facebook_id)) // ignore insert
		{
			$this->db->insert('a3m_account_facebook', array('account_id' => $account_id, 'facebook_id' => $facebook_id, 'linkedon' => mdate('%Y-%m-%d %H:%i:%s', now()), 'token' => $token));
			return TRUE;
		}
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete account facebook
	 *
	 * @access public
	 * @param int $facebook_id
	 * @return void
	 */
	function delete($facebook_id)
	{
		$this->db->delete('a3m_account_facebook', array('facebook_id' => $facebook_id));
	}

}


/* End of file account_facebook_model.php */
/* Location: ./application/account/models/account_facebook_model.php */