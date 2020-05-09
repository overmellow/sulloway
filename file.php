<?php
$myfile = fopen("counter.txt", "r+") or die("Unable to open file!");
$val = fgets($myfile);
echo $val;
rewind($myfile);
fwrite($myfile, ++$val);
fclose($myfile);
?>