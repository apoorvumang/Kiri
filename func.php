<?php 
function isPresent($main, $sub)
{
	if(strpos($main, $sub)===false)
		return false;
	else
		return true;
}
?>