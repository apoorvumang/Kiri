<?php
//Using rottentomatoes
//query to movie conversion might be a bit broken(gives multiple consecutive spaces)
function getMovie($text)
{
	$text = " ".$text." ";
	$toremove = array(" movie ", " review ", " what ", " how ", " is ", " the ", " for ", " rating ");
	$movie = str_replace($toremove, " ", $text);
	$movie_without_space = str_replace(" ", "+", $movie);
	$obj = json_decode(file_get_contents("http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=xdffvvg9k75cu9a9e32tw686&q=".$movie_without_space."&page_limit=1"));
	if(isset($obj->movies[0]->title))
	{
		$review = $obj->movies[0]->title.". ";
		// if(isset($obj->movies[0]->ratings->audience_rating))
		// 	$review = $review.$obj->movies[0]->ratings->audience_rating." ";
		if(isset($obj->movies[0]->ratings->audience_score))
			$review = $review."Score : ".$obj->movies[0]->ratings->audience_score." out of 100. ";
		if(isset($obj->movies[0]->critics_consensus))
			$review = $review.$obj->movies[0]->critics_consensus;
		return $review;
	}
	else
		return "Movie not found.";
}
?>