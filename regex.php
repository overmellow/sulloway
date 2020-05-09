<?php
preg_match('/(?<=About ).*(?= results)/', 'About 893,000 results (0.62 seconds)', $matches);
echo "<pre>";
var_dump($matches[0]);
echo $matches[0];
echo "</pre>";
?>