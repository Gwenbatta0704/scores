<?php

define('DB_PATH', $_SERVER['DOCUMENT_ROOT'] . '/data/scores.sqlite');
define('TODAY', (\Carbon\Carbon::now('Europe/Brussels')->locale('fr_BE'))
    ->isoFormat('dddd DD, MMMM YYYY'));