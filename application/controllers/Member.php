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
		if ($this->login) {
			redirect('member');
		} else {
			$data = array();
			if ($this->post_exist()) {
				$data = $this->input->post();
				if ($data['agree'] !== 'on') {
					$data['error'] = 'You should agree with our terms and conditions';
				} else {
					$result = $this->User_model->get_by_email($data['email']);
					if ($result) {
						$data['error'] = 'Email already registered';
					} else {
						$params = array(
							'email' => $data['email'],
							'password' => md5(SALT . $data['password']),
							'firstname' => $data['first'],
							'lastname' => $data['last']
						);
					}
				}
			}
			$this->load_header('Member Signup');
			$this->load->view('auth/signup', $data);
			$this->load_footer();
		}
	}
}
