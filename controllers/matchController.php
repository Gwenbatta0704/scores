<?php
namespace matchControllers;

use function Match\save as saveMatch;

function store(\PDO $pdo): void
{
    $matchDate = $_POST['match-date'];
    $homeTeam = $_POST['home-team'];
    $awayTeam = $_POST['away-team'];
    $homeTeamGoals = $_POST['home-team-goals'];;
    $awayTeamGoals = $_POST['away-team-goals'];

    $match = [
        'date' => $matchDate,
        'home-team' => $homeTeam,
        'home-team-goal' => $homeTeamGoals,
        'away-team-goal' => $awayTeamGoals,
        'away-team' => $awayTeam
    ];
    saveMatch($pdo, $match);
    header('Location:index.php');
    exit();
}