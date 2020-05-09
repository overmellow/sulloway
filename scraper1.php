<?php
// example of how to use basic selector to retrieve HTML contents
include('./simplehtmldom/simple_html_dom.php');
 
// // get DOM from URL or file
//$html = file_get_html('http://www.google.com');
$opts = array(
     'http'=>array(
       'header'=>"User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36\r\n"
     )
   );

$context = stream_context_create($opts);
// $url = "http://localhost:1010/server.php"; 
//$url = "http://localhost/mine.html";    
// $url = 'https://www.google.com/search?num=100&en&q=%22+Hilarious+Will+Smith+%22&meta=%22';
$url = 'https://www.google.com/search?num=100&en&q="+Marty++Feldman+was+very+funny+"&meta="';
$html = file_get_html($url, false, $context);
// echo $html;
// $html = file_get_html('http://localhost/mine.html');

// // find all link
foreach($html->find('div[id=result-stats]') as $e)
     $val = $e->innertext;
     //echo preg_replace('/(?<=About ).*(?= results )/', '$1', $val);
     preg_match('/(?<=About ).*(?= results)/', $e->innertext, $matches);
     echo $e->innertext;
     var_dump($matches);
     // echo $str;
     //echo $e->innertext . '<br>';
     
     
echo "hello";
?>