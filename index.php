<?php

$header = [
    'title',
    'seo_title',
    'url',
    'author',
    'date',
    'category',
    'locales',
    'content'
];

$file = './sample.csv';
$csv= file_get_contents($file);
$array = array_map(function($line) use ($header) {
    $explodedLine = str_getcsv($line, ';');
    $ret = [];
    foreach ($explodedLine as $k => $item) {
        $ret[$header[$k]] = $item;
    }
    return $ret;
}, explode("\n", $csv));

var_dump(json_encode("Number entries : " . count($array)));

$json = json_encode($array);
