<?php
class Game_center extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//Load models needed
		$this->load->model('game_model');
	}
	function update_score () {
		$score = $this->input->post('game_score');
		$score = intval($score);
		$game_id = $_SESSION['game_id'];
		log_message('error', $game_id);
		$mx = $this->game_model->calc_score($game_id, $score);
		log_message('error', $game_id);
		$total_score = $this->game_model->update_total_score($mx);
		echo $total_score;
	}
}
