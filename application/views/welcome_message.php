<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test Page</title>
</head>
<body>
<table id="countries">
	<thead>
	<tr>
		<th>Code</th>
		<th>ID</th>
		<th>Name</th>
		<th>Abbreviation</th>
	</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<script src="public/plugins/jquery/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$.getJSON("public/player_ranking.json", function(data) {
			let wta = data.rankings[0];
			let atp = data.rankings[1];

			/*
			for (let i = 0; i < 500; i++) {
				let buffer = '<tr><td>' + wta.player_rankings[i].player.country_code;
				buffer += '</td><td>';
				buffer += wta.player_rankings[i].player.id;
				buffer += '</td><td>';
				buffer += wta.player_rankings[i].player.name;
				buffer += '</td><td>';
				buffer += wta.player_rankings[i].player.abbreviation + '</td></tr>';
				$("#countries tbody").append(buffer);
			}

			for (let i = 0; i < 500; i++) {
				let buffer = '<tr><td>' + atp.player_rankings[i].player.country_code;
				buffer += '</td><td>';
				buffer += atp.player_rankings[i].player.id;
				buffer += '</td><td>';
				buffer += atp.player_rankings[i].player.name;
				buffer += '</td><td>';
				buffer += atp.player_rankings[i].player.abbreviation + '</td></tr>';
				$("#countries tbody").append(buffer);
			}
			*/

			console.log(atp.player_rankings[0].player);
		});
	});
</script>
</body>
</html>