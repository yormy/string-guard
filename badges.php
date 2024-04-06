<?php

echo 'badges';

$path = 'test.json';
$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString);

echo $jsonData->summary->code;
