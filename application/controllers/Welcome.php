<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page
	 */
	public function index() {
		/*
		$file = fopen('wta.csv', 'rb');
		while (($line = fgetcsv($file)) !== FALSE) {
			$row = $this->Country_model->get_country_by_code($line[0]);
			$params = array(
				'country' => $row['id'],
				'unique' => $line[1],
				'name' => $line[2],
				'abbr' => $line[3]
			);
			$this->Player_model->add_player($params, 'wta');
		}
		fclose($file);
		*/
		$this->load->view('welcome_message');
	}
}
