<?php 
  
// From URL to get webpage contents. 
// $url = "http://localhost/mine.html"; 
$url = "https://www.google.com/search?num=100&en&q=%22+Hilarious+Will+Smith+%22&meta=%22";
  
// Initialize a CURL session. 
$ch = curl_init();  
  
// Return Page contents. 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36');
  
//grab URL and pass it to the variable. 
curl_setopt($ch, CURLOPT_URL, $url); 
  
$result = curl_exec($ch); 
  
echo $result;  
  
?> 