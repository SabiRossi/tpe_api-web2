<?php
require_once './libs/router.php';
require_once './app/controllers/player-api.controller.php';
require_once './app/controllers/auth-api.controller.php';

//creo el router
$router = new router();

//creo tabla de ruteo

$router->addRoute('players', 'GET', 'PlayerApiController', 'getPlayers');
$router->addRoute('players/:ID', 'GET', 'PlayerApiController', 'getPlayerById');
$router->addRoute('players/:ID', 'DELETE', 'PlayerApiController', 'deletePlayer');
$router->addRoute('players', 'POST', 'PlayerApiController', 'insertPlayer');
$router->addRoute('players/:ID', 'PUT', 'PlayerApiController', 'UpdatePlayer');

$router->addRoute('auth/token', 'GET', 'AuthApiController', 'getToken');

//ejecuto la ruta

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
