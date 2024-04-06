<?php

echo 'badges';

$path = './badges/phpinsights.json11111';
if (!file_exists($path))
{
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
