<?php

$router->get('/', 'controllers/index.php');

$router->get('/map', 'controllers/map.php');

$router->get('/login', 'controllers/session/create.php')->only('guest');
$router->post('/login', 'controllers/session/store.php')->only('guest');
$router->delete('/logout', 'controllers/session/destroy.php')->only('auth');

$router->get('/api/houses', 'controllers/api/houses.php');
$router->get('/api/places', 'controllers/api/places.php');