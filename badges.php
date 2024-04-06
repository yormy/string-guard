<?php

echo 'badges';

$path = './badges/phpinsights.json';
if (!file_exists($path))
{
//    $file = 'badges/debug1.txt';
//    file_put_contents($file, getcwd(), FILE_APPEND | LOCK_EX);


    exec("wget https://img.shields.io/badge/test_badge_coverage-missing-red -O badges/coverage.svg");
    return;
}

$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString);

$codePercentage = (int)$jsonData?->summary?->code;
if (!$codePercentage) {
    $codePercentage = 1;
}

exec("wget https://img.shields.io/badge/test_badge_coverage-$codePercentage%25-blue -O badges/coverage.svg");
