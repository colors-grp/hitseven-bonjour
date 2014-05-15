<?php
class Round_model Extends CI_Model{
    //gets current rounds according to sitecode and server date
    function getCurrentRound($sitecode) {
            //$sql = "SELECT c.name , r.round_id , r.name, UNIX_TIMESTAMP(r.start_date) as start_date , UNIX_TIMESTAMP(NOW()) as now , UNIX_TIMESTAMP(r.end_date) as end_date FROM competition AS c , competition_round AS r WHERE c.id = r.competition_id AND SYSDATE() >= r.start_Date AND SYSDATE() <= r.end_date;";
    	$this->db->select('c.name, r.round_id, r.name, UNIX_TIMESTAMP(r.start_date) as start_date , UNIX_TIMESTAMP(NOW()) as now , UNIX_TIMESTAMP(r.end_date) as end_date');
            $this->db->from('competition_round AS r, competition AS c');
            $this->db->where('r.competition_id = '.$sitecode.'  AND c.id = r.competition_id AND UNIX_TIMESTAMP(r.start_date) <= UNIX_TIMESTAMP(NOW()) AND UNIX_TIMESTAMP(r.end_date) >= UNIX_TIMESTAMP(NOW())');
            $query = $this->db->get();
            log_message('error','mo7eb round_model getCurrentRound $query='.print_r($query,TRUE));
            if ($query != FALSE && $query->num_rows() > 0)
                    return $query;
            return FALSE;
	}
    //gets all rounds that have't started yet
    function getNextRounds(){
        $sql = "SELECT c.name , r.* FROM competition AS c , competition_round AS r WHERE c.id = r.competition_id AND r.start_Date > SYSDATE();";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
                return $query;
        return FALSE;
    }
    //returns all rounds
    function getAllRounds(){
        $sql = "SELECT c.name , r.* FROM competition AS c , competition_round AS r WHERE c.id = r.competition_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
                return $query;
        return FALSE;
    }
    //returns all rounds according to round_id
    function getRounds($roundID){
        $sql = "SELECT c.name , r.* FROM competition AS c , competition_round AS r WHERE c.id = r.competition_id AND r.round_id =".$roundID;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
                return $query;
        return FALSE;
    }
}