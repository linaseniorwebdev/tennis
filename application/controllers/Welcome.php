<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page
	 */
	public function index() {
		
	}
}

/* Load from CSV
$file = fopen('Ranking_WTA.csv', 'rb');
while (($line = fgetcsv($file)) !== FALSE) {
	$row = $this->Player_model->get_player_by_uid($line[0], 'wta');
	$params = array(
		'player' => $row['id'],
		'points' => $line[1],
		'rank' => $line[2],
		'movement' => $line[3],
		'played' => $line[4]
	);
	$this->Ranking_model->add_ranking($params, 'wta');
}
fclose($file);
*/

/* Player bio and statistics
ini_set('allow_url_fopen', 1);
ini_set('max_execution_time', 1800);

$this->load->model('Player_model');
$this->load->model('Statistics_model');
$Surfaces = array(
	'grass',
	'green clay',
	'red clay',
	'red clay indoor',
	'synthetic indoor',
	'synthetic outdoor',
	'hard court',
	'hardcourt indoor',
	'hardcourt outdoor',
	'carpet indoor'
);
for ($i = 382; $i < 383; $i++) {
	$row = $this->Player_model->get_player($i, 'wta');
	$url = 'http://api.sportradar.us/tennis-t2/en/players/' . $row['unique'] . '/profile.json?api_key=q2nm52ytytgnbdsfwg3sjfmh';
//			$url = 'http://127.0.0.1/tennis/public/player_profile.json';
	$json = file_get_contents($url);
	if ($json === false) {
		echo 'Stopped at: ' . $i;
		break;
	}
	$obj = json_decode($json, false);
	$player = $obj->player;
	$params = array(
		'gender'        => $player->gender,
		'birthday'      => $player->date_of_birth,
		'professional'  => $player->pro_year,
		'handedness'    => $player->handedness,
		'height'        => $player->height,
		'weight'        => $player->weight,
	);
	$this->Player_model->update_player($row['id'], $params, 'wta');
	$periods = $obj->statistics->periods;
	foreach ($periods as $item) {
		$params = array(
			'player'    => $row['id'],
			'year'      => $item->year,
			'tp'        => $item->statistics->tournaments_played,
			'tw'        => $item->statistics->tournaments_won,
			'mp'        => $item->statistics->matches_played,
			'mw'        => $item->statistics->matches_won
		);
		$TP = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$TW = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$MP = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$MW = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($item->surfaces as $surface) {
			$index = array_search(strtolower($surface->type), $Surfaces, true);
			if ($index !== false) {
				$TP[$index] += $surface->statistics->tournaments_played;
				$TW[$index] += $surface->statistics->tournaments_won;
				$MP[$index] += $surface->statistics->matches_played;
				$MW[$index] += $surface->statistics->matches_won;
			}
		}
		$params['stp'] = implode(',', $TP);
		$params['stw'] = implode(',', $TW);
		$params['smp'] = implode(',', $MP);
		$params['smw'] = implode(',', $MW);
		$this->Statistics_model->add_statistics($params, 'wta');
	}
}
*/