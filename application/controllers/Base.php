<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/User.php';

class Base extends CI_Controller {

	public $user, $login, $admin, $vars;

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();

		if ($this->session->user) {
			$this->load->model('User_model');
			$user = $this->User_model->get_by_id($this->session->user);
			$this->user = User::init($user);
			$this->login = true;
		} else {
			$this->user = new User();
			$this->login = false;
		}

		if ($this->session->admin) {
			$this->admin = $this->session->admin;
		}

//		$this->load->model('System_model');
//		$this->vars = $this->System_model->get_all_system_variables();
	}

	/**
	 * Load header file, with title
	 * @param $title
	 * @param null $admin
	 */
	public function load_header($title, $admin = null) {
		if ($admin) {
			$this->load->view('admin/header', array('title' => $title));
		} else {
			$this->load->view('front/header', array('title' => $title));
		}
	}

	/**
	 * Load footer file
	 * @param null $admin
	 * @param null $name
	 */
	public function load_footer($admin = null, $name = null) {
		if ($admin) {
			if ($name) {
				$this->load->view('admin/footer', array('name' => $name));
			} else {
				$this->load->view('admin/footer');
			}
		} else {
			$this->load->view('front/footer');
		}
	}

	/**
	 * Check if post data exist
	 */
	public function post_exist() {
		return isset($_POST) && count($_POST) > 0;
	}

	/**
	 * Check if get data exist
	 */
	public function get_exist() {
		return isset($_GET) && count($_GET) > 0;
	}
	
	/**
	 * Set output header as HTTP 400
	 */
	public function bad_request() {
		$this->output->set_status_header('400', 'Bad Request');
	}

	/**
	 * Set output header as HTTP 500
	 */
	public function server_error() {
		$this->output->set_status_header('500', 'Internal Server Error');
	}

	/**
	 * Get system variable
	 * @param $key
	 * @return mixed
	 */
	public function getVar($key) {
		return $this->vars[$key];
	}

	/**
	 * Get time based unique ID
	 */
	public function getUID() {
		$date = new DateTime();
		return $date->getTimestamp();
	}

	/**
	 * Encode Array to String
	 * @param $arr
	 * @return false|string
	 */
	public function encodeArray($arr) {
		return json_encode($arr);
	}

	/**
	 * Decode String to Array
	 * @param $str
	 * @return mixed
	 */
	public function decodeArray($str) {
		return json_decode($str, true);
	}
}
