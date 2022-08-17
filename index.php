<?php

use function Team\all as allTeams;
use function Match\allWithTeams as allMatchesWithTeams;
use function Match\allWithTeamsGrouped as allMatchesWithTeamsGrouped;


require('configs/config.php');
require('utils/dbaccess.php');

require('models/team.php');
require('models/match.php');

$pdo = getConnection();

define('TODAY', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('M jS, Y'));

$standings = [];

$matches2 = allMatchesWithTeamsGrouped(allMatchesWithTeams($pdo));

$teams = allTeams($pdo);

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

foreach ($matches2 as $match){
    $homeTeam = $match->home_team;
    $awayTeam = $match->away_team;
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
    if ($match->home_team_goals === $match->away_team_goals){
        $standings[$homeTeam]['Points']++;
        $standings[$awayTeam]['Points']++;
        $standings[$homeTeam]['Draws']++;
        $standings[$awayTeam]['Draws']++;
    }

    // Compte  Victoire et Defaite
    else if ($match->home_team_goals > $match->away_team_goals){
        $standings[$homeTeam]['Points']+=3;
        $standings[$homeTeam]['Wins']++;
        $standings[$awayTeam]['Losses']++;

    }else{
        $standings[$awayTeam]['Points']+=3;
        $standings[$homeTeam]['Losses']++;
        $standings[$awayTeam]['Wins']++;
    }

    // Compte nombre de goals
    $standings[$homeTeam]['GF']+= $match->home_team_goals;
    $standings[$homeTeam]['GA']+= $match->away_team_goals;
    $standings[$awayTeam]['GF']+= $match->away_team_goals;
    $standings[$awayTeam]['GA']+= $match->home_team_goals;
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

require('vue.php');