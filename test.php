<?php
$stturl = "https://www.google.com/speech-api/v1/recognize?xjerr=1&client=chromium&lang=en-IN";
	$upload = file_get_contents("try1.flac");
	$data = array(
	    "Content_Type"  =>  "audio/x-flac; rate=16000",
	    "Content"       =>  $upload,
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $stturl);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type: audio/x-flac; rate=16000"));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	ob_start();
	curl_exec($ch);
	curl_close($ch);
	$contents = ob_get_contents();
	ob_end_clean();
	$textarray = (json_decode($contents,true));
	$text = $textarray['hypotheses']['0']['utterance'];

	echo $text;
?>