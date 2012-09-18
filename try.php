<?php
echo system("bin/sox try1.wav try1convert.flac");
sleep(2);
echo file_get_contents("./try1convert.flac");
?>