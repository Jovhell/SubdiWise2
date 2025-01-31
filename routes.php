<?php

$router->get('/', 'controllers/index.php')->only('authenticated');

$router->get('/map', 'controllers/map.php');

$router->get('/login', 'controllers/session/create.php')->only('guest');
$router->post('/login', 'controllers/session/store.php');