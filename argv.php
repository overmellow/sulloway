<?php
// var_dump($argv);

$val = getopt("p:");

if ($name !== false) {
	echo var_export($val, true);
}
else {
	echo "Could not get value of command line option\n";
}
?>