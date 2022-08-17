<?php
define('TODAY', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('M jS, Y'));
const FILEPATH = 'matches.csv';
$matches = [];
$standings = [];
$teams = [];

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

$handle = fopen(FILEPATH, 'r'); //mode read -> lecture
$headers = fgetcsv($handle, 1000);

// boucle qui créer les équipe
while ($line = fgetcsv($handle, 1000)) {
    $match = array_combine($headers, $line);
    $matches[] = $match; // égale un push en JS
    $homeTeam = $match['home-team'];
    $awayTeam = $match['away-team'];

    // si homeTeam n'existe pas encore -> push dasn $standings
    if (!(array_key_exists($homeTeam, $standings))){
        $standings[$homeTeam] = getEmptyStatArray();
    }

    // si awayTeam n'existe pas encore -> push dasn $standings
    if (!(array_key_exists($awayTeam, $standings))){
        $standings[$awayTeam] = getEmptyStatArray();
    }
    // Compte nombre de match TOTAL
    $standings[$homeTeam]['Games']++;
    $standings[$awayTeam]['Games']++;

    //Compte nombre match NUL
    if ($match['home-team-goals'] === $match['away-team-goals']){
        $standings[$homeTeam]['Points']++;
        $standings[$awayTeam]['Points']++;
        $standings[$homeTeam]['Draws']++;
        $standings[$awayTeam]['Draws']++;
    }

    // Compte  Victoire et Defaite
    else if ($match['home-team-goals'] > $match['away-team-goals']){
        $standings[$homeTeam]['Points']+=3;
        $standings[$homeTeam]['Wins']++;
        $standings[$awayTeam]['Losses']++;

    }else{
        $standings[$awayTeam]['Points']+=3;
        $standings[$homeTeam]['Losses']++;
        $standings[$awayTeam]['Wins']++;
    }

    // Compte nombre de goals
    $standings[$homeTeam]['GF']+= $match['home-team-goals'];
    $standings[$homeTeam]['GA']+= $match['away-team-goals'];
    $standings[$awayTeam]['GF']+= $match['away-team-goals'];
    $standings[$awayTeam]['GA']+= $match['home-team-goals'];
    $standings[$homeTeam]['GD'] = $standings[$homeTeam]['GF'] - $standings[$homeTeam]['GA'];
    $standings[$awayTeam]['GD'] = $standings[$awayTeam]['GF'] - $standings[$awayTeam]['GA'];
}

//réorganiser le tableau
uasort($standings,function ($a,$b){
    if ($a['Points'] === $b['Points']){
        return 0;
    }
    return $a['Points'] > $b['Points'] ? -1 : 1;

});

$teams = array_keys($standings);
sort($teams);

require('vue.php');