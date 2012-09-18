<?php 
session_start();
require_once('log.php');
require_once("stt.php");
require_once("ttw.php");
require_once("response.php");
$r = new Response();
$r->setFiller("yes");
if($_REQUEST['event']=="NewCall")
{	
	$r->addPlayText('Welcome to Kiri');
	$r->addPlayText('Speak after the beep');
	$r->addRecord("test.wav", "wav", "2", "5");
}
else if($_REQUEST['event']=="Record")
{
    sleep(3);
    $text = speechToText($_REQUEST['data']);
    write_log($text, 'log.txt');
    if(!$text)
    {
    	$r->addPlayText('Sorry, I was unable to understand your voice');
    }
    else
    {
	    $answer = textToWolfram($text);
	    write_log($answer, 'log.txt');
	    if($answer)
	    {
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
	$r->addPlayText('Thankyou for calling Kiri');
	$_SESSION['state'] = '0';
}
else
{
	$r->addHangup();
}
$r->send();
?>