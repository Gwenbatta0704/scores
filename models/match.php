<?php

namespace Match;

function all(\PDO $connection): array
{
    $matchesRequest = 'SELECT * FROM matches ORDER BY date';
    $pdoSt = $connection->query($matchesRequest);

    return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id): \stdClass
{
    $matchRequest = 'SELECT * FROM matches WHERE id = :id';
    $pdoSt = $connection->prepare($matchRequest);
    $pdoSt->execute([':id' => $id]);

    return $pdoSt->fetch();
}

function allWithTeams(\PDO $connection): array
{
    $matchesInfoRequest = '
    SELECT *
    FROM matches m
    JOIN participations p on m.id = p.match_id
    JOIN teams t on t.id = p.team_id
    ORDER BY m . id , p . is_home';

    $pdoSt = $connection->query($matchesInfoRequest);

    return $pdoSt->fetchAll();
}

function allWithTeamsGrouped(array $allWithTeams): array
{
    $matchesWithTeams = [];
    $m = null;
    foreach ($allWithTeams as $match) {
        if (!$match->is_home) {
            $m = new \stdClass();
            $d = new \DateTime();
            $d->setTimestamp(((int)$match->date) / 1000);
            $m->match_date = $d;
            $m->away_team = $match->name;
            $m->away_team_goals = (int)$match->goals;
            $m->away_team_logo = $match->file_name;
        } else {
            $m->home_team = $match->name;
            $m->home_team_goals = (int)$match->goals;
            $m->home_team_logo = $match->file_name;
            $matchesWithTeams[] = $m;
        }
    }

    return $matchesWithTeams;
}

function save(\PDO $connection, array $match)
{
    $insertMatchRequest = 'INSERT INTO matches(`date`,`slug`) VALUES (:date, :slug)';
    $pdoSt = $connection->prepare($insertMatchRequest);
    $pdoSt->execute([':date' => $match['date'], ':slug' => '']);
    $id = $connection->lastInsertId();
    $insertParticipationRequest = 'INSERT INTO participations(`match_id`,`team_id`,`goals`,`is_home`) 
                                        VALUES (:match_id,:team_is,:goals,:is_home)';
    $pdoSt = $connection->prepare($insertParticipationRequest);
    $pdoSt->execute([
        ':match_id' => $id,
        ':team_is' => $match['home-team'],
        ':goals' => $match['home-team-goal'],
        ':is_home' => 1
    ]);
    $pdoSt = $connection->prepare($insertParticipationRequest);
    $pdoSt->execute([
        ':match_id' => $id,
        ':team_is' => $match['away-team'],
        ':goals' => $match['away-team-goal'],
        ':is_home' => 0
    ]);
    return $pdoSt->fetchAll();

}