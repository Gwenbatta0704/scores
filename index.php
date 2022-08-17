<?php


require('./vendor/autoload.php');

require('./configs/config.php');
require('./utils/dbaccess.php');
require('./utils/standings.php');


$pdo = getConnection();

$route = require('./utils/router.php');

$data = call_user_func($route['callback'], $pdo);

require('./controllers/'.$route['controller'].'php');

extract($data, EXTR_OVERWRITE);

require($view);

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    if (isset($_POST['action']) && isset($_POST['resource'])) {
//        if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {
//            storeMatch($pdo);
//        } elseif ($_POST['action'] === 'store' && $_POST['resource'] === 'team') {
//            storeTeam($pdo);
//        }
//    }
//} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//    if (!isset($_GET['action']) && !isset($_GET['resource'])) {
//        $data = dashboardPage($pdo);
//    }
//
//} else {
//    header('Location:index.php');
//    exit();
//}
//
