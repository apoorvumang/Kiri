<?php
	$STDOUT = fopen("php://stderr", "w");
	fwrite($STDOUT, "Output #1.");
	fclose($STDOUT);
?>