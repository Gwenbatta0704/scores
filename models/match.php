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
    $matchesInfoRequest = 'SELECT * FROM matches
    JOIN participations p on matches.id = p.match_id
    JOIN teams t on t.id = p.team_id
    GROUP BY t.slug
    ORDER BY matches . id;';

    $pdoSt = $connection->query($matchesInfoRequest);

    return $pdoSt->fetchAll();
}