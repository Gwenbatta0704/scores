<?php

namespace teamControllers;


require('models/team.php');

use function Team\save as saveTeam;

function store(\PDO $pdo): void
{
    $name = $_POST['name'];
    $slug = $_POST['slug'];

    saveTeam($pdo, compact('name', 'slug'));

    header('Location:index.php');
    exit();
}