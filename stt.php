<?php
function speechToText($url_record)
{
	//$url_record = "http://drmahima.com/try1.wav";
	//assume $url_record contains url of sound recording (.wav)


	// File Conversion start
	// $ch = curl_init("http://api.online-convert.com/queue-insert");
	// $request["queue"] = file_get_contents("convertapi1.xml").$url_record.file_get_contents("convertapi2.xml");
	// curl_setopt($ch, CURLOPT_HEADER, 0);
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	// $response = curl_exec($ch);
	// curl_close ($ch);

	// function get_data($url) {
	//   $ch = curl_init();
	//   $timeout = 5;
	//   curl_setopt($ch, CURLOPT_URL, $url);
	//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	//   $data = curl_exec($ch);
	//   curl_close($ch);
	//   return $data;
	// }
	// sleep(12);
	// $xml = simplexml_load_string($response);

	// $url_converted = strip_tags($xml->params->downloadUrl->asXML());
	// $result = get_data($url_converted);
	// preg_match("/<a href=\"([^\"]*)\.flac\">(.*)<\/a>/iU", $result, $matches
	// $curl_handle=curl_init();
	// curl_setopt($curl_handle, CURLOPT_URL, $matches[1]);
	// curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 20);
	// curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($curl_handle, CURLOPT_USERAGENT, 'STT try');
	// $query = curl_exec($curl_handle);
	// curl_close($curl_handle);
	// File conversion end. result stored in $query

	file_put_contents("temp.wav", file_get_contents($url_record));
	sleep(1);
	shell_exec('./flac temp.wav -o temp.flac -f');
	sleep(2);
	$query = file_get_contents('temp.flac');

	// ini_set('default_socket_timeout', 20);
	// file_put_contents("Tmpfile.flac", file_get_contents($matches[1]));

	// Google STT
	$stturl = "https://www.google.com/speech-api/v1/recognize?xjerr=1&client=chromium&lang=en-IN";
	$upload = $query;//file_get_contents("./Tmpfile.flac");
	$data = array(
	    "Content_Type"  =>  "audio/x-flac; rate=44100",
	    "Content"       =>  $upload,
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $stturl);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type: audio/x-flac; rate=44100"));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	ob_start();
	curl_exec($ch);
	curl_close($ch);
	$contents = ob_get_contents();
	ob_end_clean();
	$textarray = (json_decode($contents,true));
	$text = $textarray['hypotheses']['0']['utterance'];

	return $text;
}
?>