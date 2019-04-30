<?php

class Country_model extends CI_Model {

	/**
	 * Get country by id
	 * @param $id
	 * @return array
	 */
	public function get_country($id) {
		return $this->db->get_where('countries', array('id' => $id))->row_array();
	}

	/**
	 * Get country by code
	 * @param $code
	 * @param int $type
	 * @return array
	 */
	public function get_country_by_code($code, $type = 1) {
		return $this->db->get_where('countries', array('code' . $type => $code))->row_array();
	}

	/**
	 * Get all countries
	 */
	public function get_all_countries() {
		$this->db->order_by('id', 'asc');
		return $this->db->get('countries')->result_array();
	}

	/**
	 * Function to add new country
	 * @param $params
	 * @return int
	 */
	public function add_country($params) {
		$this->db->insert('countries', $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update country
	 * @param $id
	 * @param $params
	 * @return boolean
	 */
	public function update_country($id, $params) {
		$this->db->where('id', $id);
		return $this->db->update('countries', $params);
	}

	/**
	 * Function to delete country
	 * @param $id
	 * @return boolean
	 */
	public function delete_country($id) {
		return $this->db->delete('countries', array('id' => $id));
	}
}
