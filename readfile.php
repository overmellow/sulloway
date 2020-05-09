<?php
include('./simplehtmldom/simple_html_dom.php');
// $myfile = fopen("list.txt", "r+") or die("Unable to open file!");
// echo fread($myfile, filesize("list.txt"));
// fclose($myfile);

$opts = array(
    'http'=>array(
      'header'=>"User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36\r\n"
    )
  );

$context = stream_context_create($opts);
$array = file('list.txt');
$remaining_array = Array();
$successful_array = Array();

foreach($array as $e) {
    $url = "http://localhost:1010/server.php?name=";
    $new_e =str_replace(' ', '+', rtrim($e));
    $url .= $new_e;
    // echo $new_e . ' :: ' . $url .' :: ';
    $html = file_get_html($url, false, $context);

    while($html == false OR empty($html)) 
    {
        $html = file_get_html($url, false, $context);
    } 

    // echo $html;
    if($html !== false AND !empty($html)){
        echo "Correct<br>";
        foreach($html->find('div[id=result-stats]') as $el)
        {
            $val = $el->innertext;
            preg_match('/(?<=About ).*(?= results)/', $val, $matches);
            // echo $matches[0] . '<br>';
            array_push($successful_array, Array(rtrim($e), $url, filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)));
        }

    } else {
        array_push($remaining_array, rtrim($e)); 
        echo "False<br>";
    }   
    //preg_match('/(?<=About ).*(?= results )/', 'About 893,000 results (0.62 seconds)', $matches);
}

// foreach($remaining_array as $arr){
//     file_put_contents('remaining.txt', $arr, FILE_APPEND);
// }

function writeToFile($filename, $array)
{
    foreach($array as $arr){
        $temp = "";
        if(gettype($arr) === 'array')
        {
            foreach($arr as $a) {
                $temp .= $a . ", ";   
            }
        }
        else
        {
            $temp .= $arr;
        }         
        
        $temp .= "\n";
        // $temp = $arr[0] . ", " . $arr[1] . ", " . $arr[2] ."\n";
        // echo $temp;
        file_put_contents($filename, $temp, FILE_APPEND);
    }
}

writeToFile('success.csv', $successful_array);
writeToFile('remaining.csv', $remaining_array);
?>