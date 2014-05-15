<?php
class User_model extends CI_Model {
	function get_user_id($user_id) {
		$this->db->select('*');
		$this->db->where('id', $user_id);
		$query = $this->db->get('a3m_account');
		if ($query->num_rows() > 0)
			return $query->row();
		return FALSE;
	}
	function get_card_parameters($card_id) {
		$this->db->select('*');
		$this->db->where('id', $card_id);
		$query = $this->db->get('card');
		return (($query != FALSE && $query->num_rows() > 0)?$query: FALSE);
	}
        function get_all_fullname_id(){
            $sql = "SELECT id, fullname FROM a3m_account;";
            $query = $this->db->query($sql);
            return (($query->num_rows() > 0)?$query: FALSE);
        }
        function get_user_details($user_id){
            $sql = "SELECT * FROM a3m_account_details WHERE account_id = " . $user_id;
            $query = $this->db->query($sql);
            return (($query->num_rows() > 0)?$query: FALSE);
        }
        function get_all_details(){
            $sql = "SELECT * FROM a3m_account_details";
            $query = $this->db->query($sql);
            return (($query->num_rows() > 0)?$query: FALSE);
        }
}