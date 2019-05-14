<?php

class Token_model extends CI_Model {

	/**
	 * Get token by id
	 * @param $id
	 * @return array
	 */
	public function get_token($id) {
		return $this->db->get_where('tokens', array('id' => $id))->row_array();
	}

	/**
	 * Get all tokens
	 */
	public function get_all_tokens() {
		$this->db->order_by('id', 'asc');
		return $this->db->get('tokens')->result_array();
	}

	/**
	 * Function to add new token
	 * @param $params
	 * @return int
	 */
	public function add_token($params) {
		$this->db->insert('tokens', $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update token
	 * @param $id
	 * @param $params
	 * @return boolean
	 */
	public function update_token($id, $params) {
		$this->db->where('id', $id);
		return $this->db->update('tokens', $params);
	}

	/**
	 * Function to delete token
	 * @param $id
	 * @return boolean
	 */
	public function delete_token($id) {
		return $this->db->delete('tokens', array('id' => $id));
	}

	/**
	 * Get activation token
	 * @param $token
	 * @return mixed
	 */
	public function get_activation_token($token) {
		return $this->db->get_where('tokens', array('token' => $token, 'action' => 0))->row_array();
	}
}
