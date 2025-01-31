<?php

const BASE_PATH = __DIR__ . "/../";

session_start();

require BASE_PATH . 'util.php';

require base_path('classes/Database.php');
require base_path('classes/Router.php');
require base_path('classes/Validator.php');
require base_path('classes/Middleware/Middleware.php');
require base_path('classes/Middleware/Guest.php');
require base_path('classes/Middleware/Admin.php');
require base_path('classes/Middleware/User.php');
require base_path('classes/Middleware/Authenticated.php');


$router = new Router();

$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);