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
$remaining = Array();
$successful = Array();

scrapeGoogle($array, $remaining, $successful);

saveRemaining($remaining);
saveSuccessful($remaining);

function saveRemaining(&$remaining) {
    foreach($remaining as $arr){
        echo "hey";
        file_put_contents('remaining.txt', $arr, FILE_APPEND);
    }
}

function saveSuccessful(&$successful) {
    foreach($successful as $arr){
        echo "heya";
        $temp = $arr[0] . ', ' . $arr[1] . ', ' . $arr[2];
        // echo $temp;
        file_put_contents('successful.csv', $temp, FILE_APPEND);
    }
}

function scrapeGoogle(&$array, &$remaining_array, &$successful_array){
    foreach($array as $e) {
        $url = "http://localhost:1010/server.php?name=";
        $new_e =str_replace(' ', '+', rtrim($e));
        $url .= $new_e;
        // echo $new_e . ' :: ' . $url .' :: ';
        $html = file_get_html($url, false, $context);
    
        // echo $html;
        if($html !== false AND !empty($html)){
            echo "Correct<br>";
            foreach($html->find('div[id=result-stats]') as $el)
            {
                $val = $el->innertext;
                preg_match('/(?<=About ).*(?= results)/', $val, $matches);
                // echo $matches[0] . '<br>';
                // array_push($successful_array, Array($e, $url, filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)));
                addToSuccessful($successful_array, Array($e, $url, filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)));
            }
    
        } else {
            addToRemaining($remaining_array, $e);
            echo "False<br>";
        }   
    }
}

function addToRemaining(&$remaining_array, $to_be_added) {
    echo "ppp";
    array_push($remaining_array, $to_be_added); 
}

function addToSuccessful(&$successful_array, &$to_be_added) {
    echo "hhh";
    array_push($successful_array, $to_be_added); 
}

?>