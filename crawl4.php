<?php
require_once 'simple_html_dom.php';


allPages("https://agencyanalytics.com");


function allPages($url){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    $dom = new simple_html_dom();
    $dom->load($html);
    $links = $dom->find('a');
    
    foreach (array_slice($links, 0, 8) as $link) {
    crawlWebsite("https://agencyanalytics.com".$link->href);
     }


}

function crawlWebsite($url)
{
    // code to crawl website goes here
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $dom = new simple_html_dom();
    $dom->load($html);

    // Extract internal and external links
    $internal_links = 0;
    $external_links = 0;
    $links = $dom->find('a');
    
    foreach ($links as $link) {
      
        $href = $link->href;
       // echo $href;
        //echo "<br>";
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



    $title = $dom->find("title", 0)->plaintext;
    $titlelenght=strlen($title);

    $text = $dom->plaintext;
    $word_count = str_word_count($text);

    echo "PageUrl: " . $url . "<br>";
    echo "PageStatus: " . $httpCode . "<br>";
    echo "Number of internal links: " . $internal_links . "<br>";
    echo "Number of external links: " . $external_links . "<br>";
    echo "Number of images: " . $image_count . "<br>";
    echo "Page loading time: " . $loading_time . " seconds" . "<br>";
    echo "Title of the webpage: " . $title . "<br>";
    echo "Title length: " . $titlelenght. "<br>";
    echo "Number of words in the webpage: " . $word_count . "<br>";
    echo "<br>";
    



}
