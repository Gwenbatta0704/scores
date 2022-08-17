<?php

define('TODAY', (new DateTime('now',
    new DateTimeZone('Europe/Brussels')))
    ->format('M jS, Y'));

function getEmptyStatArray(): array
{
return [
'Games' => 0,
'Points' => 0,
'Wins' => 0,
'Losses' => 0,
'Draws' => 0,
'GF' => 0,
'GA' => 0,
'GD' => 0,
];
}