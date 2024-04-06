<?php
$path = './badges/phpinsights.json';
$coverageText = 'coverage';

$scoreLow = 30;
$scoreMedium = 60;

if (!file_exists($path))
{
//    $file = 'badges/debug1.txt';
//    file_put_contents($file, getcwd(), FILE_APPEND | LOCK_EX);
    exec("wget https://img.shields.io/badge/$coverageText-missing-red -O badges/coverage.svg");
    return;
}

$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString);

$codePercentage = (int)$jsonData?->summary?->code;
if ($codePercentage < $scoreLow) {
    $color = 'red';
} elseif ($codePercentage < $scoreMedium) {
    $color = 'orange';
} else {
    $color = 'green';
}

exec("wget https://img.shields.io/badge/$coverageText-$codePercentage%25-$color -O badges/coverage.svg");
