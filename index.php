<?php


require_once(__DIR__ . "/TP.php");

$tp = new TP();


$file = __DIR__ . '/blog.csv';
$tp->exercice1($file);

//$ch = curl_init();
//curl_setopt_array($ch, [
//    CURLOPT_URL => "kibana:5601",
//    CURLOPT_POST => true,
//    CURLOPT_POSTFIELDS => '',
//    CURLOPT_RETURNTRANSFER => true
//]);
//
//
//$output = curl_exec($ch);
//
//curl_close($ch);
//
//
//var_dump($output);
