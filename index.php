<?php

$header = ['title', 'seo_title', 'url', 'author', 'date', 'category', 'locales', 'content'];

$file = __DIR__ . '/blog.csv';
$csv = file_get_contents($file);

$array = array_map(function ($line) use ($header) {
    $explodedLine = str_getcsv($line, ';');

    if (count($explodedLine) != count($header)) {
        return null;
    }

    return array_combine($header, $explodedLine);
}, explode("\n", $csv));


$array = array_filter($array);

var_dump("Number entries : " . count($array));

$json = json_encode($array);
