<?php
include('./simplehtmldom/simple_html_dom.php');
include('user_agents.php');
include('fake_search_terms.php');

$remaining_array = Array();
$successful_array = Array();

$val = getopt("t:p:f:");

$search_fixed_term = $val['t'];
$position = $val['p'];
$names_filename = $val['f'];

$array = file($names_filename);

define("TERMS", $search_fixed_term);
define("POSITION", $position);

foreach($array as $e) {
    $url = prepareSearchTermUrl($e);
    echo $url;
    $context = getUserAgentHeader($user_agents);
    exit("done");

    $html = file_get_html($url, false, $context);

    while($html == false OR empty($html)) 
    {
        $html = file_get_html($url, false, $context);
    } 

    // echo $html;
    if($html !== false AND !empty($html)){
        // echo "<br>Correct<br>";
        $actual_result = '';
        $total_result = '';
        foreach($html->find('div[id=result-stats]') as $el)
        {
            $val = $el->innertext;
            preg_match('/(?<=About ).*(?= results)/', $val, $matches);
            $total_result = $matches[0];
        }

        foreach($html->find('p[id=ofr] ') as $el)
        {
            $val = $el->children(0)->innertext;
            preg_match('/(?<=In order to show you the most relevant results, we have omitted some entries very similar to the ).*(?= already displayed)/', $val, $matches);
            $actual_result = $matches[0];
        }
        
    } else {
        array_push($remaining_array, rtrim($e)); 
        // echo "<br>False<br>";
    }
    
    array_push($successful_array, Array(trim($e), $url, filter_var($total_result, FILTER_SANITIZE_NUMBER_INT), filter_var($actual_result, FILTER_SANITIZE_NUMBER_INT)));
    $string_to_file = trim($e) .  ", " . $url .  ", " . filter_var($total_result, FILTER_SANITIZE_NUMBER_INT) .  ", " . filter_var($actual_result, FILTER_SANITIZE_NUMBER_INT);
    writeStringToFile('success.csv', $string_to_file);
}

function writeArrayToFile($filename, $array)
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

function writeStringToFile($filename, $string)
{ 
    file_put_contents($filename, $string . "\n", FILE_APPEND);
}

function makeFakeSearchRequest($fake_search_terms)
{
    $url = $fake_search_terms[rand(0, count($fake_search_terms))];
    file_get_html($url, false, $context);
}

function prepareSearchTermUrl($e)
{
    $e = trim($e);
    if(POSITION == "pre"){
        $e_with_fixed_terms = TERMS . " " . $e;
    } else {
        $e_with_fixed_terms = $e . " " . TERMS;
    }    
    // echo $e_with_fixed_terms . "\n";
    $searchWords = str_replace(' ', '+', $e_with_fixed_terms);
    // echo $searchWords . "\n";
    
    $final_url = 'https://www.google.com/search?num=100&en&q="' . $searchWords . '"&meta=""';
    // $final_url = 'http://localhost/server.html';
    return $final_url;
}

function getUserAgentHeader($user_agents)
{
    $opts = array(
        'http'=>array(
          'header'=>"User-Agent:" . $user_agents[rand(0, count($user_agents))] . "\r\n"
        )
      );
    var_dump($opts);
    return stream_context_create($opts);
}

writeArrayToFile('success_array.csv', $successful_array);
writeToFile('remaining.csv', $remaining_array);
?>