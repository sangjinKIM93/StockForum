<?php
include 'simple_html_dom.php';

$html = file_get_html('https://finance.naver.com/item/main.nhn?code=005930');
//echo $html;

//$a = $html->find('span[class=blind]');
$a = $html->find('div[class=today]');




    $c = $a[0]->find('span[class=blind]');
    $filted_c = $c[0];
    // $href = $b->href;
    // $filtered_href = 'https://www.youtube.com'.$href;
    // $b->href = $filtered_href;
    // array_push($links, $filtered_href);
    echo $filted_c;
    // $title = $b->innertext;
    // array_push($titles, $title);




?>

