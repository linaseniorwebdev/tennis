<?php

class User_model extends CI_Model {

	private $table, $column_order, $column_search, $order;

	/**
	 * Construct
	 */
	public function __construct() {
		parent::__construct();

		$this->table = 'users';
		$this->column_order = array(null, 'id');
		$this->column_search = array('username', 'firstname', 'lastname');
		$this->order = array('id' => 'asc');
	}

	public function getRows($postData) {
		$this->_get_datatables_query($postData);
		if($postData['length'] != -1){
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
		foreach($this->column_search as $item) {
			if($postData['search']['value']) {
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

		if(isset($postData['order'])) {
			$this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
		} else if(isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	/**
	 * Get user by id
	 * @param $id
	 * @return array
	 */
	public function get_user($id) {
		return $this->db->get_where('users', array('id' => $id))->row_array();
	}

	/**
	 * Get all users
	 */
	public function get_all_users() {
		$this->db->order_by('id', 'desc');
		return $this->db->get('users')->result_array();
	}

	/**
	 * Function to add new user
	 * @param $params
	 * @return int
	 */
	public function add_user($params) {
		$this->db->insert('users', $params);
		return $this->db->insert_id();
	}

	/**
	 * Function to update user
	 * @param $id
	 * @param $params
	 * @return bool
	 */
	public function update_user($id, $params) {
		$this->db->where('id', $id);
		return $this->db->update('users', $params);
	}

	/**
	 * Function to delete user
	 * @param $id
	 * @return mixed
	 */
	public function delete_user($id) {
		return $this->db->delete('users', array('id' => $id));
	}

	/**
	 * Function to get user by id
	 * @param $user_id
	 * @return array
	 */
	public function get_by_id($user_id) {
		return $this->db->get_where('users', array('id' => $user_id))->row_array();
	}

	/**
	 * Function to get user by name
	 * @param $name
	 * @return array
	 */
	public function get_by_name($name) {
		return $this->db->get_where('users', array('username' => $name))->row_array();
	}

	/**
	 * Function to get user by email
	 * @param $email
	 * @return array
	 */
	public function get_by_email($email) {
		return $this->db->get_where('users', array('email' => $email))->row_array();
	}
}
