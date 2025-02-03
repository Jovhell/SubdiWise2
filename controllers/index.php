<?php

$views = [
    'admin' => [
        'view' =>'admin/index.php',
        'style' => 'main.css',
        'navlinks' => [
            ['url' => '/', 'text' => 'Home'],
            ['url' => '/dashboard', 'text' => 'Dashboard']
        ]
    ],
    'user' => [
        'view' =>'user/index.php',
        'style' => 'main.css'
    ],
    'default' => [
        'view' =>'landing.php',
        'style' => ''
    ]
];

$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? 'default';

view($views[$role]['view'], [
    'title' => 'SubdiWise',
    'style' => $views[$role]['style'],
    'navlinks' => $views[$role]['navlinks'] ?? []
]);