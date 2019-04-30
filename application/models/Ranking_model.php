<?php

class Ranking_model extends CI_Model {

	/**
	 * Get ranking by id
	 * @param $id
	 * @param string $type
	 * @return array
	 */
	public function get_ranking($id, $type = 'atp') {
		return $this->db->get_where('rankings_' . $type, array('id' => $id))->row_array();
	}

	/**
	 * Get all rankings
	 * @param string $type
	 * @return array
	 */
	public function get_all_rankings($type = 'atp') {
		$this->db->order_by('id', 'asc');
		return $this->db->get('rankings_' . $type)->result_array();
	}

	/**
	 * Function to add new ranking
	 * @param $params
	 * @param string $type
	 * @return int
	 */
	public function add_ranking($params, $type = 'atp') {
		$this->db->insert('rankings_' . $type, $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update ranking
	 * @param $id
	 * @param $params
	 * @param string $type
	 * @return boolean
	 */
	public function update_ranking($id, $params, $type = 'atp') {
		$this->db->where('id', $id);
		return $this->db->update('rankings_' . $type, $params);
	}

	/**
	 * Function to delete ranking
	 * @param $id
	 * @param string $type
	 * @return boolean
	 */
	public function delete_ranking($id, $type = 'atp') {
		return $this->db->delete('rankings_' . $type, array('id' => $id));
	}
}
