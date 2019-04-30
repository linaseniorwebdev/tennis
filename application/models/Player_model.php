<?php

class Player_model extends CI_Model {

	/**
	 * Get player by id
	 * @param $id
	 * @param string $type
	 * @return array
	 */
	public function get_player($id, $type = 'atp') {
		return $this->db->get_where('players_' . $type, array('id' => $id))->row_array();
	}

	/**
	 * Get player by unique id
	 * @param $uid
	 * @param string $type
	 * @return array
	 */
	public function get_player_by_uid($uid, $type = 'atp') {
		return $this->db->get_where('players_' . $type, array('unique' => $uid))->row_array();
	}

	/**
	 * Get all players
	 * @param string $type
	 * @return array
	 */
	public function get_all_players($type = 'atp') {
		$this->db->order_by('id', 'asc');
		return $this->db->get('players_' . $type)->result_array();
	}

	/**
	 * Function to add new player
	 * @param $params
	 * @param string $type
	 * @return int
	 */
	public function add_player($params, $type = 'atp') {
		$this->db->insert('players_' . $type, $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update player
	 * @param $id
	 * @param $params
	 * @param string $type
	 * @return boolean
	 */
	public function update_player($id, $params, $type = 'atp') {
		$this->db->where('id', $id);
		return $this->db->update('players_' . $type, $params);
	}

	/**
	 * Function to delete player
	 * @param $id
	 * @param string $type
	 * @return boolean
	 */
	public function delete_player($id, $type = 'atp') {
		return $this->db->delete('players_' . $type, array('id' => $id));
	}
}
