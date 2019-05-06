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
<div>
	<?php
	if (strpos($con = ini_get('disable_functions'), 'fsockopen') === false) {
		if (is_resource($fs = fsockopen('www.livescore.in', 80, $errno, $errstr, 3)) && !($stop = $write = !fwrite($fs, 'GET //free/lsapi HTTP/1.1\r\nHost: www.livescore.in\r\nConnection: Close\r\nlsfid: 293270\r\n\r\n'))) {
			$content = '';
			while (!$stop && !feof($fs)) {
				$line = fgets($fs, 128);
				($write || $write = $line === '\r\n') && ($content .= $line);
			}
			fclose($fs);
			$c = explode('\n', $content);
			foreach($c as &$r) {
				$r = preg_replace('/^[0-9A-Fa-f]+\r/', '', $r);
			}
			$content = implode('', $c);
		} else {
			$content .= $errstr . '(' . $errno . ')<br />\n';
		}
	} elseif (strpos($con, 'file_get_contents') === false && ini_get('allow_url_fopen')) {
		$content = file_get_contents('http://www.livescore.in/free/lsapi', false, stream_context_create(array('http' => array('timeout' => 3, 'header' => 'lsfid: 293270 '))));
	} elseif (extension_loaded('curl') && strpos($con, 'curl_') === false) {
		curl_setopt_array($curl = curl_init('http://www.livescore.in/free/lsapi'), array(CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => array('lsfid: 293270 ')));
		$content = curl_exec($curl);curl_close($curl);
	} else {
		$content = 'PHP inScore cannot be loaded. Ask your web hosting provider to allow `file_get_contents` function along with `allow_url_fopen` directive or `fsockopen` function.';
	} echo $content;
	?>
</div>
<script src="public/plugins/jquery/jquery.min.js"></script>
<script>

</script>
</body>
</html>