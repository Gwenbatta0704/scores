<?php
const FILEPATH = 'matches.csv';

function appendArrayToCsv(array $array, string $csvFile)
{
    $handle = fopen($csvFile, 'a');
    fputcsv($handle, $array);
    fclose($handle);
}

if (isset($_POST['action']) && isset($_POST['resource'])) {
    if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {

        $matchDate = $_POST['match-date'];
        $homeTeam = ucfirst($_POST['home-team-unlisted']) === '' ? ucfirst($_POST['home-team']) : ucfirst($_POST['home-team-unlisted']) ;
        $awayTeam = ucfirst($_POST['away-team-unlisted']) === '' ? ucfirst($_POST['away-team']) : ucfirst($_POST['away-team-unlisted']) ;
        $homeTeamGoals =  $_POST['home-team-goals'];;
        $awayTeamGoals = $_POST['away-team-goals'];

        $match = [$matchDate, $homeTeam, $homeTeamGoals, $awayTeamGoals, $awayTeam];

        appendArrayToCsv($match,FILEPATH);
    }
}
header('Location: index.php');
exit();