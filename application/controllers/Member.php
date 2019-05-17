<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/Base.php';

class Member extends Base {

	/**
	 * Index page
	 */
	public function index() {
		if ($this->login) {
			// Check if user already activated
			if ($this->user->getStatus() === 0) {
				redirect('member/needs_activation');
			}

			// Check if user chose membership plan
			if ($this->user->getMembership() === 0) {
				redirect('member/membership');
			}
			echo 'Index Page';
		} else {
			redirect('member/signin');
		}
	}

	/**
	 * Sign in module
	 */
	public function signin() {
		if ($this->login) {
			redirect('member');
		} else {
			$data = array();
			if ($this->post_exist()) {
				$data = $this->input->post();
				$username = $data['username'];
				$password = $data['password'];
				$user = $this->User_model->get_by_email($username);
				if ($user) {
					// Track User's IP Address
					$res = unserialize($data['geodata']);
					$user_ip = $res['geoplugin_request'];

					$params = array(
						'user' => $user['id'],
						'ip' => $user_ip
					);

					$this->load->model('User_log_model');

					if ($user['password'] === md5(SALT . $password)) {
						$params['status'] = 1;
						$this->User_log_model->add_log($params);
						$this->session->set_userdata('user', $user['id']);
						redirect('member');
					} else {
						$data['error'] = 'Incorrect password';
						$params['status'] = 0;
						$this->User_log_model->add_log($params);
					}
				} else {
					$data['error'] = 'Unregistered user';
				}
			}
			$this->load_header('Member Login');
			$this->load->view('auth/signin', $data);
			$this->load_footer();
		}
	}

	/**
	 * Sign up module
	 * @throws Exception
	 */
	public function signup() {
		if ($this->login) {
			redirect('member');
		} else {
			$data = array();
			if ($this->post_exist()) {
				$data = $this->input->post();
				if (!isset($data['agree'])) {
					$data['agree'] = 'off';
				}
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

						// Send activation mail
						if ($this->sendmail('welcome', $data['email'], $maildata)) {
							$this->load->model('Token_model');
							$params = array('token' => $token, 'user' => $user_id, 'action' => 0);
							$this->Token_model->add_token($params);
							redirect('member/mail/sent');
						} else {
							redirect('member/mail/failed');
						}
					}
				}
			}
			$this->load_header('Member Signup');
			$this->load->view('auth/signup', $data);
			$this->load_footer();
		}
	}

	/**
	 * Logout module
	 */
	public function logout() {
		$this->session->unset_userdata('user');
		redirect('/');
	}

	/**
	 * Email send module
	 * @param $module
	 * @param $address
	 * @param $data
	 * @return bool
	 */
	private function sendmail($module, $address, $data) {
		$this->email->initialize();
		$this->email->from(ROOT_MAIL, ROOT_NAME);
		$this->email->to($address);
		$this->email->subject($data['title']);
		$this->email->message($this->load->view('email/' . $module, $data, TRUE));
		if ($this->email->send()) {
			return true;
		}
		return false;
	}

	/**
	 * After-end-mail module
	 * @param null $com
	 */
	public function mail($com = null) {
		if ($com) {
			if ($com === 'sent') {
				$this->load_header('Email sent successfully');
				$this->load->view('front/email_sent');
				$this->load_footer();
			} elseif ($com === 'failed') {
				$this->load_header('Oops!');
				$this->load->view('front/email_fail');
				$this->load_footer();
			} else {
				$this->bad_request();
			}
		} else {
			$this->bad_request();
		}
	}

	/**
	 * User activation for the first time
	 * @param null $token
	 */
	public function activate($token = null) {
		if ($token) {
			$this->load->model('Token_model');
			$row = $this->Token_model->get_activation_token($token);
			if ($row) {
				$this->User_model->update_user($row['user'], array('status' => 1));
				$this->Token_model->delete_token($row['id']);
				redirect('member');
			} else {
				$this->bad_request();
			}
		} else {
			$this->bad_request();
		}
	}

	/**
	 * User needs account activation
	 */
	public function needs_activation() {
		$this->load_header('Your account needs activation');
		$this->load->view('front/needs_activation');
		$this->load_footer();
	}

	/**
	 * Request for an activation
	 * @throws Exception
	 */
	public function request_activation() {
		// Generate Token
		$zone = new DateTimeZone('America/Argentina/Buenos_Aires');
		$now = new DateTime('now', $zone);
		$token = md5($now->format('Y-m-d H:i:s')) . md5($this->user->getEmail());

		// Prepare for Sending Mail
		$maildata = array(
			'title' => 'Account Confirmation',
			'app_name' => 'Tennis Prediction',
			'first_name' => $this->user->getFirst(),
			'action_url' => base_url('member/activate/' . $token)
		);

		// Send activation mail
		if ($this->sendmail('welcome', $this->user->getEmail(), $maildata)) {
			$this->load->model('Token_model');
			$params = array('token' => $token, 'user' => $this->user->getId(), 'action' => 0);
			$this->Token_model->add_token($params);
			redirect('member/mail/sent');
		} else {
			redirect('member/mail/failed');
		}
	}

	/**
	 * Select membership
	 */
	public function membership() {
		$this->load_header('Select your membership plan');
		$this->load->view('front/membership');
		$this->load_footer();
	}
}
