<?php

echo 'badges';

$path = 'phpinsights.json';
$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString);

$codePercentage = $jsonData->summary->code;

exec("wget https://img.shields.io/badge/test_badge_coverage-$codePercentage%25-blue -O badges/coverage.svg");
