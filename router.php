<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 09:50
 */

session_start();

require 'configs/routes.php';
$default_route = $routes['default'];
$route_parts = explode('/', $default_route);
$method = $_SERVER['REQUEST_METHOD'];
$r = $_REQUEST['r']??$route_parts[1]; // récupérer la Ressource
$a = $_REQUEST['a']??$route_parts[2];// récupérer l'Action
$id = $_REQUEST['id']??$route_parts[3]; // récupérer l'ID (Si besoin ?)

// $controllerFile = $r . 'Controller.php'; lorsque j'aurai séparé mes contrôlleurs
require 'controllers/controller.php';
$data = call_user_func($a); // ?