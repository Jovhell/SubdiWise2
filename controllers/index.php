<?php

$views = [
    'admin' => [
        'view' =>'pages/admin/index.php',
        'style' => 'main',
        'navlinks' => [
            ['url' => '/', 'text' => 'Home'],
            ['url' => '/dashboard', 'text' => 'Dashboard']
        ]
    ],
    'user' => [
        'view' =>'pages/user/index.php',
        'style' => 'main'
    ],
    'default' => [
        'view' =>'pages/landing/index.php',
        'style' => 'landing'
    ]
];

$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? 'default';

view($views[$role]['view'], [
    'title' => 'SubdiWise',
    'style' => $views[$role]['style'],
    'navlinks' => $views[$role]['navlinks'] ?? []
]);