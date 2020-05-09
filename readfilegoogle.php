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
$array = file('list1.txt');
$remaining_array = Array();
$successful_array = Array();

define("TERMS", "Hilarious");
$before = true;
$counter = 0;

foreach($array as $e) {
    echo "<br>" .++$counter . "<br>"; 
    if($before == true){
        $new_e = TERMS . " " . trim($e);
    } else {
        $new_e = trim($e) . " " . TERMS;
    }    
    // echo $new_e . "\n";
    $searchWords = str_replace(' ', '+', rtrim($new_e));
    // echo $searchWords . "\n";
    
    $url = 'https://www.google.com/search?num=100&en&q="' . $searchWords . '"&meta=""';
    // $url = 'http://localhost/server.html';
    echo $url;
    // $url .= $new_e;
    // echo $new_e . '<br>';
    // echo $new_e . ' :: ' . $url .' :: ';
    $html = file_get_html($url, false, $context);

    while($html == false OR empty($html)) 
    {
        echo "hey";
        $html = file_get_html($url, false, $context);
    } 

    // echo $html;
    if($html !== false AND !empty($html)){
        echo "<br>Correct<br>";
        $actual_result;
        $total_result;
        foreach($html->find('div[id=result-stats]') as $el)
        {
            echo $el->innertext . "\n";
            $val = $el->innertext;
            preg_match('/(?<=About ).*(?= results)/', $val, $matches);
            echo $matches[0] . '<br>';
            $total_result = $matches[0];
            // array_push($successful_array, Array(rtrim($e), $url, filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)));
        }

        foreach($html->find('p[id=ofr] ') as $el)
        {
            echo $el->children(0)->innertext . "<br>";
            $val = $el->children(0)->innertext;
            preg_match('/(?<=In order to show you the most relevant results, we have omitted some entries very similar to the ).*(?= already displayed)/', $val, $matches);
            echo $matches[0] . '<br>';
            $actual_result = $matches[0];
            // array_push($successful_array, Array(rtrim($e), $url, filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)));
        }
        
    } else {
        array_push($remaining_array, rtrim($e)); 
        echo "False<br>";
    }
    array_push($successful_array, Array(trim($e), $url, filter_var($total_result, FILTER_SANITIZE_NUMBER_INT), filter_var($actual_result, FILTER_SANITIZE_NUMBER_INT)));   

    //preg_match('/(?<=About ).*(?= results )/', 'About 893,000 results (0.62 seconds)', $matches);
}

// foreach($remaining_array as $arr){
//     file_put_contents('remaining.txt', $arr, FILE_APPEND);
// }


function writeToFile($filename, $array)
{ 
    foreach($array as $arr){
        // echo "<br>" . ++$counter2 . "<br>";
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

writeToFile('success1.csv', $successful_array);
writeToFile('remaining1.csv', $remaining_array);
?>