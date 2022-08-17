<?php
return  [
    [
        'method' => 'GET',
        'action' => '',
        'resource' => '',
        'controller' => 'page',
        'callback' => 'pageController'
    ],
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'match',
        'controller' => 'match',
        'callback' => 'matchController',
    ],
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'team',
        'controller' => 'team',
        'callback' => 'teamController',
    ],
];