<?php
function textToWolfram($text)
{
	$wolframurl = "http://api.wolframalpha.com/v2/query?appid=VVU7PG-9883K63QVE&format=plaintext&podtitle=Result&input=";
	$wolframurl .= urlencode($text);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $wolframurl);
    ob_start();
    curl_exec($ch);
    curl_close($ch);
    $contents = ob_get_contents();
    ob_end_clean();
    $obj = new SimpleXMLElement($contents);
    $answer = $obj->pod->subpod->plaintext;
    return $answer;
}
?>