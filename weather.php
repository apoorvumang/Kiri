<?php
// execute query
// get list of 15 most popular music releases
// retrieve result as SimpleXML object
require_once('functions.php');

function getWeather($text)
{
	$cityarr = array(
		"calcutta" => "Kolkata",
		"delhi" => "New_Delhi", 
		"kolkata" => "Kolkata", 
		"mumbai" => "Mumbai", 
		"bombay" => "Bombay",
		"pilani" => "Pilani",
		"biryani" => "Pilani",
		"palani" => "Pilani",
		"in july" => "Pilani",
		"a line" => "Pilani",
		"hyderabad" => "Hyderabad",
		"kharagpur" => "Kharagpur",
		"jaipur" => "Jaipur",
		"bangalore" => "Bangalore",
		"bengaluru" => "Bangalore",
		"patna" => "Patna",
		"goa" => "Panaji");//, "Chandigarh", "Amritsar", "Ranchi", "Surat", "Ahmedabad", "Bhubaneshwar", "Roorkee", "Guwahati", "Srinagar");

	foreach ($cityarr as $city => $city_alt) 
	{
		if(isPresent($text, $city)===true)
		{
			$xml = simplexml_load_file('http://api.wunderground.com/api/f9dd924d7c35c148/forecast/q/india/'.$city_alt.'.xml');
			foreach($xml->forecast->simpleforecast->forecastdays->forecastday as $forecast)
			{
				$answer = "High of ".$forecast->high->celsius." and low of ".$forecast->low->celsius." and conditions will be ".$forecast->conditions;
				return $answer;
			}
		}	
	}
	return "Could not find weather information for your city";
}

?>
