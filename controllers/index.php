<?php

$views = [
    'admin' => [
        'view' =>'pages/admin/index.php',
        'style' => 'main',
        'navlinks' => [
            ['url' => '/', 'text' => 'Home'],
            ['url' => '/dashboard', 'text' => 'Dashboard'],
            ['url' => '/vicinity', 'text' => 'Vicinity'],
            ['url' => '/transactions', 'text' => 'Transactions']
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

if($role != 'default') {
    $db = new Database();
    $posts = $db->query("SELECT * FROM posts INNER JOIN users ON posts.author_id = users.id WHERE privacy = 'public' ORDER BY created_at DESC")->fetchAll();
}

view($views[$role]['view'], [
    'title' => 'SubdiWise',
    'style' => $views[$role]['style'],
    'navlinks' => $views[$role]['navlinks'] ?? [],
    'posts' => $posts
]);