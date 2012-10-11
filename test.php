<?php
	$STDOUT = fopen("php://stdout", "w");
	fwrite($STDOUT, "Output #1.");
	fclose($STDOUT);
?>