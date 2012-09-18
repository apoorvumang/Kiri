<?php
echo system("bin/sox try1.wav try1convert.flac > out.txt");
echo system("whoami > out.txt");
//echo file_get_contents("./try1convert.flac");
?>