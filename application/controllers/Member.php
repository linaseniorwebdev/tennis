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
						// Track User's IP Address
						$res = unserialize($data['geodata']);
						$user_ip = $res['geoplugin_request'];

						// Ready data for User Registration
						$params = array(
							'email' => $data['email'],
							'password' => md5(SALT . $data['password']),
							'firstname' => $data['first'],
							'lastname' => $data['last']
						);

						// Register New User
						$user_id = $this->User_model->add_user($params);

						// Generate Token
						$zone = new DateTimeZone('America/Argentina/Buenos_Aires');
						$now = new DateTime('now', $zone);
						$token = md5($now->format('Y-m-d H:i:s')) . md5($data['email']);

						// Prepare for Sending Mail
						$maildata = array(
							'title' => 'Account Confirmation',
							'app_name' => 'Tennis Prediction',
							'first_name' => $data['first'],
							'action_url' => base_url('member/activate/' . $token)
						);

						/*  Not completed yet */
						if ($this->sendmail('welcome', $data['email'], $maildata)) {

						}

						$this->load->model('Token_model');
						$params = array('token' => $token, 'user' => $user_id, 'action' => 0);
						$this->Token_model->add_token($params);

					}
				}
			}
			$this->load_header('Member Signup');
			$this->load->view('auth/signup', $data);
			$this->load_footer();
		}
	}

	private function sendmail($module, $address, $data) {
		$this->email->initialize();
		$this->email->from(ROOT_MAIL, ROOT_NAME);
		$this->email->to($address);
		$this->email->subject($data['title']);
		$this->email->message($this->load->view('email/' . $module, $data, TRUE));
		if ($this->email->send()) {
			return true;
		} else {
			return false;
		}
	}
}
