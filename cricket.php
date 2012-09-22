<?php
function getCricket()
{
	$obj = json_decode(file_get_contents("http://json-cricket.appspot.com/score.json"));
	if(isset($obj->match))
	{
		$match = $obj->match.". ";
		$score = $obj->score;
		$score = str_replace('-', " for ", $score);
		$score = str_replace('(', "after ", $score);
		$score = str_replace(')', " overs", $score);
		return $obj->match." ".$obj->score;
	}
	else
		return "Could not find match data.";
}
?>