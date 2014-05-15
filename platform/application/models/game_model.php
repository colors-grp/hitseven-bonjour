<?php
class Game_model extends CI_Model{
	// Returns a certain card's games given category and card IDs
	function get_games($cat_id, $card_id) {
		$this->db->select('*');
		$this->db->from('category_card_game');
		$this->db->where('category_id', $cat_id);
		$this->db->where('card_id', $card_id);
		$this->db->join('game' ,'game.game_id = category_card_game.game_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	// Update user total score
	function update_total_score($score) {
		$category_id = $_SESSION['current_category_id'];
		$user_id = $_SESSION['user_id'];
		$this->db->where('user_id', $user_id);
		$this->db->where('category_id', $category_id);
		$query = $this->db->get('user_category')->row();
		$total_score = $score + $query->score;
		$data = array('score' =>  ($total_score));
		$this->db->where('user_id', $user_id);
		$this->db->where('category_id', $category_id);
		$this->db->update('user_category', $data);
		return $total_score;
	}
	// Update best score for a certain user in a certain game
	function calc_score($game_id, $score) {
		$user_id = $_SESSION['user_id'];
		$this->db->select('*');
		$this->db->where('max_score', 'yes');
		$this->db->where('game_id', $game_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_game');
		$is_max = 'yes';
		$mx = 0;
		if ($query->num_rows() > 0) {
			$mx = $query->row()->score;
			$mx = intval($mx);
			$score = intval($score);
			if ($score > $mx) {
				$data = array('max_score' => 'no');
				$this->db->where('max_score', 'yes');
				$this->db->where('game_id', $game_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_game', $data);
			}
			else
				$is_max = 'no';
		}
		$data = array('user_id' => $user_id, 'game_id' => $game_id, 'score' => $score, 'max_score' => $is_max, 'time' => gmdate("F jS,Y h:i:s a", time()));
		$this->db->insert('user_game', $data);
		$mx = $score - $mx;
		if ($mx < 0)
			$mx = 0;
		return $mx;
		
	}
	function add_mcq_question($question) {
		$this->db->insert('question', $question);
	}
	// Get question given certain category and card IDs
	function get_questions($game_id) {
		$this->db->select('*');
		$this->db->from('game_question');
		$this->db->where('game_id', $game_id);
		$this->db->join('question' ,'question.question_id = game_question.question_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	function is_played($game_id) {
		$user_id = $_SESSION['user_id'];
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$this->db->where ('game_id', $game_id);
		$this->db->where ('max_score', 'yes');
		$query = $this->db->get('user_game');
		if ($query->num_rows() > 0)
			return $query->row()->score;
		return '-1';
	}
	function get_puzzle_stuff($game_id) {
		$this->db->select('*');
		$this->db->where('game_id', $game_id);
		$query = $this->db->get('puzzle');
		if ($query->num_rows() > 0)
			return $query->row();
		return FALSE;
	}
        function checkAnyGames($cat_id, $card_id){
            $sql = "SELECT * FROM category_card_game AS ccg WHERE ccg.category_id=".$cat_id." AND ccg.card_id=".$card_id." LIMIT 0,1;";
            $query = $this->db->query($sql);
            return ($query->num_rows() > 0)?true:false;
        }
}