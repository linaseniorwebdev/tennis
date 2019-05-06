<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/Base.php';

class Member extends Base {

	public function index() {
		if ($this->login) {
			echo 'Index Page';
		} else {
			redirect('member/signin');
		}
	}

	public function signin() {
		if ($this->login) {
			redirect('member');
		} else {
			$this->load_header('Member Login');
			$this->load->view('auth/signin');
			$this->load_footer();
		}
	}

	public function signup() {

	}
}
