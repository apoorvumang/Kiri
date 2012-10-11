<?php 
//recording file url
//http://recordings.kookoo.in/wyd/test.wav.wav
//state is 0 means state is undefined (ie next step should be independent of state)
session_start();
require_once("functions.php");
//require_once("log.php"); won't work on heroku
require_once("response.php");
require_once("weather.php");
require_once("movie.php");
require_once("cricket.php");

console_log(implode(',', $_REQUEST));
$r = new Response();
$callback_url = "http://kiri.herokuapp.com/kookoo.php";
$r->setFiller("yes");
if($_REQUEST['event']=="NewCall"||$_SESSION['state']=='2')
{	
    if($_REQUEST['event']=="NewCall")
    	$r->addPlayText('Welcome to Kiri');
    $r->addPlayText('Speak after the beep');
	$r->addRecord("test.wav", "wav", "3", "10", "k", $callback_url);
    $_SESSION['state'] = '0';
}
//else if($_REQUEST['event']=="Record")
else if($_REQUEST['transcript_text'])
{
    $text = $_REQUEST['transcript_text'];//speechToText($_REQUEST['data']);
    write_log($text, 'log.txt');
    if(!$text)
    {
    	$r->addPlayText('Sorry, I was unable to understand your voice');
    }
    else
    {
    	//Successfuly transcribed, now looking for specific words
        $flag = 0;
        if(isPresent($text, "weather")===true)
        {
            $answer = getWeather($text);
        }
        elseif(isPresent($text, 'movie')===true||isPresent($text, 'review')===true)
        {
            $answer = getMovie($text);
        }
        elseif(isPresent($text, 'cricket')===true&&isPresent($text, 'score')===true)
        {
            $answer = getCricket();
        }
        elseif (isPresent($text, sprintf("%c%c%c%c%c",100,97,100,100,121))===true)
        {
            $answer = sprintf("%c%c%c%c%c%c",112,114,101,114,97,107);
        }
    	elseif(isPresent($text, 'name')===true&&isPresent($text, 'your')===true)
	{
		$answer = 'My name is Kiri';
	}
	elseif(isPresent($text, 'who')===true&&isPresent($text, 'you')===true)
	{
		$answer = 'I am Kiri';
    	}
        else
        {
            $answer = textToWolfram($text);
            $flag = 1;
        }
		write_log($answer, 'log.txt');
	    if($answer)
        {
            if($flag===1)
                $r->addPlayText('Your answer is');
            $r->addPlayText($answer);
        }
        else
            $r->addPlayText('Unable to find answer for your question');
   	}
    $_SESSION['state'] = '1';
}
else if($_SESSION['state']=='1')
{
    $cd = new CollectDtmf();
    $cd->setMaxDigits("1");
    $cd->setTimeOut("2000");
    $cd->addPlayText("Press 1 to ask again 0 to exit");
    $r->addCollectDtmf($cd);
	$_SESSION['state'] = '0';
}
else if($_REQUEST['event']=='GotDTMF')
{
    if($_REQUEST['data']=='1')
        $_SESSION['state'] = '2';
    else
        $_SESSION['state'] = '0';
}
else if($_SESSION['state']=='0')
{
    $r->addPlayText('Thankyou for calling Kiri');
    $_SESSION['state'] = '-1';
}
else
{
	$r->addHangup();
}
$r->send();
?>