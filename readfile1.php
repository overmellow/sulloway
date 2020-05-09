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
$remaining_array = new ArrayObject($array);

for ($j = 0; $j < count($remaining_array); $j++) {
    $array = new ArrayObject($remaining_array);
    for($i = 0;  $i < count($array); $i++) {
        $url = "http://localhost:1010/server.php?name=";
        $new_e =str_replace(' ', '+', rtrim($remaining_array[$i]));
        $url .= $new_e;
        echo $new_e . ' :: ' . $url .' :: ';
        $html = file_get_html($url, false, $context);
    
        // echo $html;
        if($html !== false AND !empty($html)){
            echo "Correct<br>";
            foreach($html->find('div[id=result-stats]') as $el)
            {
                $val = $el->innertext;
                preg_match('/(?<=About ).*(?= results)/', $val, $matches);
                // echo $matches[0] . '<br>';
                array_push($successful_array, Array($array[$i], $url, filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)));
            }
    
        } else {
            array_push($remaining_array, $array[$i]); 
            echo "False<br>";
        }   
        //preg_match('/(?<=About ).*(?= results )/', 'About 893,000 results (0.62 seconds)', $matches);
    }
    
}

echo count($remaining_array);

// }
foreach($remaining_array as $arr){
    file_put_contents('remaining.txt', $arr, FILE_APPEND);
}
foreach($successful_array as $arr){
    $temp = $arr[0] . ', ' . $arr[1] . ', ' . $arr[2];
    // echo $temp;
    file_put_contents('successful.csv', $temp, FILE_APPEND);
}


?>