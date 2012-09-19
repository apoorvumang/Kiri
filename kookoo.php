<?php 
//recording file url
//http://recordings.kookoo.in/wyd/test.wav.wav
session_start();
require_once("functions.php");
require_once("log.php");
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
    	//Successfuly transcribed, now looking for specific words
    	if((isPresent($text, 'you')===true)||(isPresent($text, 'your')===true))
    	{
    		if(isPresent($text, 'name')===true)
    		{
    			$answer = 'My name is Kiri';
    		}
    		elseif(isPresent($text, 'who')===true)
    		{
    			$answer = 'I am Kiri';
    		}
    		else
    		{
    			$answer = 'Your answer is '.textToWolfram($text);	
    		}
    	}
    	else
    	{
		    $answer = 'Your answer is '.textToWolfram($text);
		}
		write_log($answer, 'log.txt');
	    if($answer==='Your answer is ')
            $r->addPlayText('Unable to find answer for your question');
        else
	    	$r->addPlayText($answer);	    	
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