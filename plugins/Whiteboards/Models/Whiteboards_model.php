<?php

namespace Whiteboards\Models;

use App\Models\Crud_model;

class Whiteboards_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'whiteboards';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $whiteboards_table = $this->db->prefixTable('whiteboards');
        $users_table = $this->db->prefixTable('users');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $whiteboards_table.id=$id";
        }

        $is_admin = get_array_value($options, "is_admin");
        $user_id = get_array_value($options, "user_id");
        if (!$is_admin && $user_id) {

            //find meetings where share with the user or his/her team
            $team_ids = get_array_value($options, "team_ids");
            $team_search_sql = "";

            //searh for teams
            if ($team_ids) {
                $teams_array = explode(",", $team_ids);
                foreach ($teams_array as $team_id) {
                    $team_search_sql .= " OR (FIND_IN_SET('team:$team_id', $whiteboards_table.share_with_team_members)) ";
                }
            }


            $is_client = get_array_value($options, "is_client");
            if ($is_client) {
                //client user's can't see the meetings which has shared with all team members
                $where .= " AND (FIND_IN_SET('all', $whiteboards_table.share_with_client_contacts) OR FIND_IN_SET('contact:$user_id', $whiteboards_table.share_with_client_contacts))";
            } else {
                //searh for user and teams
                $where .= " AND ($whiteboards_table.created_by=$user_id 
                OR $whiteboards_table.share_with_team_members='all'
                    OR (FIND_IN_SET('member:$user_id', $whiteboards_table.share_with_team_members))
                        $team_search_sql
                        )";
            }

            $where .= " AND $users_table.deleted=0 AND $users_table.status='active'";
        }

        $sql = "SELECT $whiteboards_table.*, 
        CONCAT($users_table.first_name, ' ',$users_table.last_name) AS created_by_name, $users_table.image AS created_by_avatar, $users_table.job_title AS created_by_job_title
        FROM $whiteboards_table
        LEFT JOIN $users_table ON $users_table.id = $whiteboards_table.created_by
        WHERE $whiteboards_table.deleted=0 $where";

        return $this->db->query($sql);
    }

    function get_client_contacts_list() {
        $users_table = $this->db->prefixTable('users');
        $clients_table = $this->db->prefixTable('clients');

        $sql = "SELECT $users_table.id, $users_table.first_name, $users_table.last_name, $clients_table.company_name
        FROM $users_table
        LEFT JOIN $clients_table ON $clients_table.id = $users_table.client_id
        WHERE $users_table.deleted=0 AND $users_table.status='active' AND $users_table.user_type='client'
        ORDER BY $users_table.first_name ASC";
        return $this->db->query($sql);
    }

}
