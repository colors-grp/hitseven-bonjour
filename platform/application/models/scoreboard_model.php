<?php
class Scoreboard_model extends CI_Model {
    //insert new user with zero score
    function insert_new_user($user_id, $user_name, $cat_name, $rank){
        $sql = "INSERT INTO ". $cat_name ."_scoreboard VALUES ('". $rank ."', '". $user_id ."', '". $user_name ."', '0', 'n') ;";
        return $this->db->query($sql);
    }
    //Get all users in a certain category to be displayed in the scoreboard
    function get_all($cat_name, $limit) {
        $sql = "SELECT * FROM ". $cat_name ."_scoreboard LIMIT ". $limit .";";
        $query = $this->db->query($sql);
        if ($query != FALSE && $query->num_rows() > 0)
                return $query;
        return FALSE;
    }

    //Get top users in a certain category to be displayed in the scoreboard
    function get_top($cat_id) {
        $this->db->select('*');
        $this->db->from('category_rank');
        $this->db->where('category_id', $cat_id);
        $this->db->join('rank', 'rank.id = category_rank.rank_id');
        $this->db->order_by('rank_id','ASC');
        $query = $this->db->get();
        if ($query != FALSE && $query->num_rows() > 0)
                return $query;
        return FALSE;
    }

    // returns top users and all users in a certain category
    function get_scoreboard($cat_id, $cat_name, $limit, $account_ids = FALSE) {
        // Get top ranks names of selected category
        $query['top'] = $this->get_top($cat_id);
        if($account_ids){ // scoreboard of friends
            $query['all'] = $this->get_all_friends($cat_name, $limit, $account_ids);
        } else {// scoreboard of all players
            $query['all'] = $this->get_all($cat_name, $limit);
            $query['top_users'] = $this->getTop($cat_name, $query['top']->num_rows());
        }
        return $query;
    }
    // returns friends ranks from scoardboard table given account_ids
    function get_all_friends($cat_name, $limit, $accounts_ids){
        $this->db->select('*');
        $this->db->from($cat_name.'_scoreboard');
        $this->db->where_in('user_id',$accounts_ids);
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    //
    function get_home_page_scoreboard($cats) {
        $res = array();
        //log_message('error','mo7eb scoreboard_model get_home_page_scoreboard $cats='.  print_r($cats,TRUE));
        for ($i = 0; $i < count($cats); $i++) {
                //Needs defensive programming
                $cat_name = $cats[$i]['name'];
                $query = $this->db->query("SELECT * FROM ". $cat_name ."_scoreboard LIMIT 3");
                $j = 0;
                $res[$i]['cat_name'] = $cat_name;
                $res[$i]['data'] = array();
                if ($query == FALSE) {
                        continue;
                }
                foreach ($query->result() as $row) {
                        $res[$i]['data'][$j] = $row;
                        $j++;
                }
        }
        return $res;
    }
    function get_sorted_cats() {
            $this->db->order_by('rank', 'asc');
            $query = $this->db->get('category');
            log_message('error','mo7eb scoreboard_model get_sorted_cats $srted_cats='.  print_r($query->result_array(),TRUE));
            if ($query != FALSE && $query->num_rows() > 0)
                    return $query;
            return FALSE;
    }
     function dummyUsersWithDummyScores($cat_name, $n_users, $users){
        $change = array(0 => "d", 1 => "n", 2 => "u");
        $size = count($users);
        $i=0;
        for($i=0;$i<$n_users;$i++){
            $rand = rand(0, $size-1);
            $sql = "INSERT INTO ". $cat_name ."_scoreboard VALUES ('". ($i+1) ."', '". ($users[$rand]->account_id) ."', '". ($users[$rand]->fullname) ."', '". ((1999 - $i)*5) ."', '". ($change[rand(0, 2)]) ."');";
            $this->db->query($sql);
        }
    }
    function emptyScores($cat_name){
        for($i=0;$i<7;$i++){
            $sql = "TRUNCATE " . $cat_name . "_scoreboard;";
            $this->db->query($sql);
        }
    }
    function getTop($cat_name, $limit){
        $sql = "SELECT * FROM ". $cat_name ."_scoreboard LIMIT ". $limit .";";
        $query = $this->db->query($sql);
        return (($query != FALSE && $query->num_rows() > 0)?$query: FALSE);
    }
    function get_user_rank($user_id, $cat_name){
        $sql = "SELECT sc.rank FROM ". $cat_name ."_scoreboard AS sc WHERE sc.user_id = ". $user_id .";";
        return $this->db->query($sql);
    }
    function get_total_scores($cat_name){
        $sql = "SELECT COUNT(rank) AS total FROM ". $cat_name ."_scoreboard ;";
        return $this->db->query($sql);
    }
    function get_dash_ranks($user_id, $cat_name, $differance, $viewLimit){
        $sql =  "SELECT * FROM ". $cat_name ."_scoreboard AS sc WHERE sc.rank >= ( SELECT ( sc.rank - ". $differance ." ) FROM ". $cat_name ."_scoreboard AS sc WHERE sc.user_id = ". $user_id ." LIMIT 1 ) LIMIT ". $viewLimit ." ;";
        return $this->db->query($sql);
    }
    function get_next($cat_name, $offset, $limit){
        $this->db->select('*');
        $this->db->from($cat_name.'_scoreboard');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }
    function get_next_in($cat_name, $offset, $limit, $accounts_ids){
        $this->db->select('*');
        $this->db->from($cat_name.'_scoreboard');
        $this->db->limit($limit, $offset);
        $this->db->where_in('user_id',$accounts_ids);
        return $this->db->get()->result_array();
    }
}