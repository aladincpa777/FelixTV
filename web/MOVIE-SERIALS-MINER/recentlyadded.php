<?php
header("Content-Type: text/html; charset=utf-8");
	$file_get = file_get_contents("http://tv.sosac.to/vystupy5981/moviesrecentlyadded.json");
	$ACTUAL = json_decode($file_get, TRUE);
	for ($i = 1; $i <= 10000; $i++) {
			//if (json_encode($ACTUAL[$i]['n']['en'], JSON_FORCE_OBJECT) == 'NULL' || json_encode($ACTUAL[$i]['n']['en'], JSON_FORCE_OBJECT) == 'null' || strpos(json_encode($ACTUAL[$i]['n']['en'], JSON_FORCE_OBJECT), "u0") !== false || json_encode($ACTUAL[$i]['n']['cs'], JSON_FORCE_OBJECT) == 'NULL' || json_encode($ACTUAL[$i]['n']['cs'], JSON_FORCE_OBJECT) == 'null') {
			//} else {
		if (json_encode($ACTUAL[$i]['n']['cs'], JSON_FORCE_OBJECT) == 'null' && json_encode($ACTUAL[$i]['n']['en'], JSON_FORCE_OBJECT) == 'null'){
		} else {
			$prepare = json_encode($ACTUAL[$i]['n']['cs'], JSON_UNESCAPED_UNICODE)." || ".json_encode($ACTUAL[$i]['n']['en'], JSON_UNESCAPED_UNICODE)." || ". json_encode($ACTUAL[$i]['l'], JSON_UNESCAPED_UNICODE)." || ". json_encode($ACTUAL[$i]['d'], JSON_UNESCAPED_UNICODE);
			$final = str_replace( '"', '', $prepare );
			$final = str_replace( chr(92), '', $final );
			$final = str_replace( ',', '', $final );
			echo $final.",";//."<br/></br>";
			//echo $final."<br />";
		}
			//}
	}
?>