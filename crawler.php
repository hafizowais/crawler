<?php
require_once 'simple_html_dom.php';
$url = $_GET["url"];
$result = [];
allPages($url);


function allPages($url){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    $dom = new simple_html_dom();
    $dom->load($html);
    $links = $dom->find('a');
    
    foreach (array_slice($links, 0, 8) as $key => $link) {
        $result[$key] = crawlWebsite($url.$link->href);
     }

     return $result;

}

function crawlWebsite($url)
{

    // code to crawl website goes here
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    

    $dom = new simple_html_dom();
    $dom->load($html);

    // Extract internal and external links
    $internal_links = 0;
    $external_links = 0;
    $links = $dom->find('a');
    
    foreach ($links as $link) {
      
        $href = $link->href;
        if (strpos($href, $url) === 0) {
            $internal_links++;
        } else {
            $external_links++;
        }
    }

    // Extract images
    $images = $dom->find('img');
    $image_count = count($images);

    // Extract page loading time
    $loading_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
    curl_close($ch);


    $title = $dom->find("title", 0)->plaintext;
    $titlelenght=strlen($title);

    $text = $dom->plaintext;
    $word_count = str_word_count($text);

    echo "<tr> " ;   
    echo "<td> " . $url . "</td>";
    echo "<td> " . $httpCode . "</td>";
    echo "<td> " . $internal_links . "</td>";
    echo "<td> " . $external_links . "</td>";
    echo "<td> " . $image_count . "</td>";
    echo "<td> " . number_format($loading_time,2) . " sec" . "</td>";
    echo "<td> " . $title . "</td>";
    echo "<td> " . $titlelenght. "</td>";
    echo "<td> " . $word_count . "</td>";
    echo "</tr>";

      



}
