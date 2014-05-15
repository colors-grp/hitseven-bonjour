<?php
class Card_model extends CI_Model {
	//Get all cards in a certain category
	function get_cards_by_id($category_id) {
		$this->db->where('category_id', $category_id);
		$query = $this->db->get('card');
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}

	//Given a user id and a category , returns cards that user owns in the category
	function get_user_cards_by_id($category_id , $user_id) {
            $this->db->select('*');
            $this->db->from('user_card');
            $this->db->where('user_card.category_id' , $category_id);
            $this->db->where('user_card.user_id' , $user_id);

            $this->db->join('card', 'user_card.card_id = card.id AND user_card.category_id = card.category_id');
            $query = $this->db->get();
            log_message('error', 'Mo7eb user cards->>>'. $category_id . '   ' . $query->num_rows());
            if($query->num_rows() > 0)
                    return $query;
            return FALSE;
	}

	//check whether user owns the card
	function own_card($cat_id , $card_id ,$user_id ) {
		$this->db->where('category_id' , $cat_id);
		$this->db->where('card_id' , $card_id);
		$this->db->where('user_id' , $user_id);
		$query = $this->db->get('user_card');
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}

	//Add card to user when card is bought
	function insert_user_card($category_id , $card_id , $user_id) {
            //log_message('error','mo7eb card_model insert_user_card $category_id='.$category_id);
            //log_message('error','mo7eb card_model insert_user_card $card_id='.$category_id);
            //log_message('error','mo7eb card_model insert_user_card $user_id='.$user_id);
		$data = array(
				'user_id' => $user_id ,
				'card_id' => $card_id ,
				'category_id' => $category_id
		);
		$this->db->insert('user_card', $data);
                //log_message('error','mo7eb card_model insert_user_card after insert in user_card');
		//$this->db->free_result();
                //log_message('error','mo7eb card_model insert_user_card after free_result()');
		// Insert new game for user
                $this->db->select('game_id');
		$this->db->where('category_id', $category_id);
		$this->db->where('card_id', $card_id);
		$query = $this->db->get('category_card_game');
		log_message('error', 'category_card_game');
		foreach ($query->result() as $row) {
			$game_id = $row->game_id;
			log_message('error', 'ele 1 ' . $game_id);
			$data = array(
					'user_id' => $user_id,
					'game_id' => $game_id,
					'max_score' => '0'
			);
			$this->db->insert('user_game', $data);
                        log_message('error','mo7eb card_model insert_user_card after insert in user_game');
		}
	}
        
        function get_category_cards($cat_id){
            $sql = "SELECT COUNT(*) AS total FROM card WHERE category_id =". $cat_id;
            $query = $this->db->query($sql);
            return $query->row()->total;
        }
        
        function get_not_interest_cards($user_id,$cat_id){
            $sql = "SELECT * FROM card AS c  WHERE c.id NOT IN (SELECT c.id FROM card AS c, user_card AS uc WHERE c.id = uc.card_id AND uc.user_id = ".$user_id." AND c.category_id = uc.category_id AND uc.category_id = ".$cat_id.") AND c.category_id = ".$cat_id.";";
            $query = $this->db->query($sql);
            if($query != FALSE && $query->num_rows() > 0)
			return $query;
            return FALSE;
        }
}