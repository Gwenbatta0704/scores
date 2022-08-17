<?php
namespace Team;


function all(\PDO $connection): array
{
    $teamsRequest = 'SELECT * FROM teams ORDER BY name';
    $pdoSt = $connection->query($teamsRequest);

    return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id): \stdClass
{
    $teamRequest = 'SELECT * FROM teams WHERE id = :id';
    $pdoSt = $connection->prepare($teamRequest);
    $pdoSt->execute([':id' => $id]);

    return $pdoSt->fetch();
}

function save(\PDO $connection, array $team)
{
    $insertTeamRequest = 'INSERT INTO teams(`date`,`slug`) VALUES (:name, :slug)';
    $pdoSt = $connection->prepare($insertTeamRequest);
    $pdoSt->execute([':name' => $team['name'], ':slug' => $team['slug']]);
//    $id = $connection->lastInsertId();
//    $insertParticipationRequest = 'INSERT INTO participations(`match_id`,`team_id`,`goals`,`is_home`)
//                                        VALUES (:match_id,:team_is,:goals,:is_home)';
//    $pdoSt = $connection->prepare($insertParticipationRequest);
//    $pdoSt->execute([
//        ':match_id' => $id,
//        ':team_is' => $match['home-team'],
//        ':goals' => $match['home-team-goal'],
//        ':is_home' => 1
//    ]);
//    $pdoSt = $connection->prepare($insertParticipationRequest);
//    $pdoSt->execute([
//        ':match_id' => $id,
//        ':team_is' => $match['away-team'],
//        ':goals' => $match['away-team-goal'],
//        ':is_home' => 0
//    ]);
//    return $pdoSt->fetchAll();

}
