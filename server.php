<?php
/*session is started if you don't write this line can't use $_Session  global variable*/
$myfile = fopen("counter.txt", "r+") or die("Unable to open file!");
$val = fgets($myfile);
rewind($myfile);
fwrite($myfile, ++$val);
fclose($myfile);

$str = "<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<h1>" . $val . "</h1>
<h1>This is a Heading</h1>
<p>This is a paragraph.</p>
<a href='https://berkeley.edu'>Berkeley</p>
<div><div id='result-stats'>About " . number_format(rand (0 , 10000000)) . " results<nobr> (0.36 seconds)&nbsp;</nobr></div></div>  
</body>
</html>";
// file_put_contents("php://output", $_SERVER[REQUEST_URI]);
if ($val % 5 != 0)
{
    //echo "hello " . $_SESSION["counter"];
    echo ($str); 
} else {
    header("HTTP/1.0 500 Internal Server Error");
    echo "";
    // file_put_contents("php://stderr", " error");
    file_put_contents("php://stderr", "IP: " . getUserIP() . "\n");
}

// file_put_contents("php://stderr", $_SERVER[REQUEST_URI]);

// Function to get the user IP address
function getUserIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


?>