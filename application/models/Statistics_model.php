<?php

class Statistics_model extends CI_Model {

	/**
	 * Get statistics by id
	 * @param $id
	 * @param string $type
	 * @return array
	 */
	public function get_statistics($id, $type = 'atp') {
		return $this->db->get_where('statistics_' . $type, array('id' => $id))->row_array();
	}

	/**
	 * Get statistics by unique id
	 * @param $uid
	 * @param string $type
	 * @return array
	 */
	public function get_statistics_by_uid($uid, $type = 'atp') {
		return $this->db->get_where('statistics_' . $type, array('unique' => $uid))->row_array();
	}

	/**
	 * Get all statistics
	 * @param string $type
	 * @return array
	 */
	public function get_all_statistics($type = 'atp') {
		$this->db->order_by('id', 'asc');
		return $this->db->get('statistics_' . $type)->result_array();
	}

	/**
	 * Function to add new statistics
	 * @param $params
	 * @param string $type
	 * @return int
	 */
	public function add_statistics($params, $type = 'atp') {
		$this->db->insert('statistics_' . $type, $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update statistics
	 * @param $id
	 * @param $params
	 * @param string $type
	 * @return boolean
	 */
	public function update_statistics($id, $params, $type = 'atp') {
		$this->db->where('id', $id);
		return $this->db->update('statistics_' . $type, $params);
	}

	/**
	 * Function to delete statistics
	 * @param $id
	 * @param string $type
	 * @return boolean
	 */
	public function delete_statistics($id, $type = 'atp') {
		return $this->db->delete('statistics_' . $type, array('id' => $id));
	}
}
