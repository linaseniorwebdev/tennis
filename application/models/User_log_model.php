<?php

class User_log_model extends CI_Model {

	private $table, $column_order, $column_search, $order;

	/**
	 * Construct
	 */
	public function __construct() {
		parent::__construct();

		$this->table = 'users_log';
		$this->column_order = array(null);
		$this->column_search = array('username', 'firstname', 'lastname');
		$this->order = array('id' => 'asc');
	}

	public function getRows($postData) {
		$this->_get_datatables_query($postData);
		if ($postData['length'] != -1){
			$this->db->limit($postData['length'], $postData['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function countAll() {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function countFiltered($postData) {
		$this->_get_datatables_query($postData);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function _get_datatables_query($postData) {
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($postData['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $postData['search']['value']);
				} else {
					$this->db->or_like($item, $postData['search']['value']);
				}

				if (count($this->column_search) - 1 === $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}

		if (isset($postData['order'])) {
			$this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
		} else if(isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	/**
	 * Get all logs
	 */
	public function get_all_logs() {
		$this->db->order_by('id', 'desc');
		return $this->db->get('users_log')->result_array();
	}

	/**
	 * Function to add new log
	 * @param $params
	 * @return int
	 */
	public function add_log($params) {
		$this->db->insert('users_log', $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update log
	 * @param $id
	 * @param $params
	 * @return bool
	 */
	public function update_log($id, $params) {
		$this->db->where('id', $id);
		return $this->db->update('users_log', $params);
	}

	/**
	 * Function to delete log
	 * @param $id
	 * @return mixed
	 */
	public function delete_log($id) {
		return $this->db->delete('users_log', array('id' => $id));
	}

	/**
	 * Function to get log by id
	 * @param $log_id
	 * @return array
	 */
	public function get_by_id($log_id) {
		return $this->db->get_where('users_log', array('id' => $log_id))->row_array();
	}
}
