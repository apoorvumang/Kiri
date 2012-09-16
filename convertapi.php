<?php
$url_record = "http://drmahima.com/Happy_Birthday.wav";
//assume $url_record contains url of sound recording (.wav)

$ch = curl_init("http://api.online-convert.com/queue-insert");
$request["queue"] = file_get_contents("convertapi1.xml").$url_record.file_get_contents("convertapi2.xml");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
$response = curl_exec($ch);
curl_close ($ch);

function get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

sleep(2);
$xml = simplexml_load_string($response);

$url_converted = strip_tags($xml->params->downloadUrl->asXML());
$result = get_data($url_converted);
preg_match("/<a href=\"([^\"]*)\.flac\">(.*)<\/a>/iU", $result, $matches);

file_put_contents("Tmpfile.flac", file_get_contents($matches[1].".flac"));

?>