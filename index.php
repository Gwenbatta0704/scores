<?php
define('TODAY', (new DateTime('now'))-> format('M jS, Y'));


$filePath = 'matches.csv';
$matches = [];



$handle = fopen($filePath,'r'); //mode read -> lecture
$headers = fgetcsv($handle,1000);
while ($line = fgetcsv($handle,1000)){
    $matches[] = array_combine($headers,$line); // égale un push en JS
}


require('vue.php');