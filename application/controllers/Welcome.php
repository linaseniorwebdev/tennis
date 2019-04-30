<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page
	 */
	public function index() {
//		$this->load->model('Player_model');
//		$this->load->model('Ranking_model');
//		$file = fopen('Ranking_WTA.csv', 'rb');
//		while (($line = fgetcsv($file)) !== FALSE) {
//			$row = $this->Player_model->get_player_by_uid($line[0], 'wta');
//			$params = array(
//				'player' => $row['id'],
//				'points' => $line[1],
//				'rank' => $line[2],
//				'movement' => $line[3],
//				'played' => $line[4]
//			);
//			$this->Ranking_model->add_ranking($params, 'wta');
//		}
//		fclose($file);
		$this->load->view('welcome_message');
	}
}
