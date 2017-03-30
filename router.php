<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 09:50
 */

session_start();

$routes = require 'configs/routes.php';
$default_route = $routes['default'];
$route_parts = explode('/', $default_route);
$method = $_SERVER['REQUEST_METHOD'];
$r = $_REQUEST['r'] ?? $route_parts[1]; // récupérer la Ressource
$a = $_REQUEST['a'] ?? $route_parts[2];// récupérer l'Action

$controllerName = 'Controller\\' . ucfirst($r);
$controller = new $controllerName();

$data = call_user_func([$controller, $a]);