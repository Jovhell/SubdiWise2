<?php

$views = [
    'admin' => [
        'view' =>'pages/admin/index.php',
        'style' => 'home',
        'navlinks' => [
            ['url' => '/', 'text' => 'Home'],
            ['url' => '/dashboard', 'text' => 'Dashboard'],
            ['url' => '/vicinity', 'text' => 'Vicinity'],
            ['url' => '/transactions', 'text' => 'Transactions']
        ]
    ],
    'user' => [
        'view' =>'pages/user/index.php',
        'style' => 'home'
    ],
    'default' => [
        'view' =>'pages/landing/index.php',
        'style' => 'landing'
    ]
];

$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? 'default';
$posts = null;
$liked_posts = null;

if($role != 'default') {
    $db = new Database();
    $posts = $db->query("SELECT users.id as user_id, posts.id as post_id, posts.*, users.* FROM posts INNER JOIN users ON posts.author_id = users.id WHERE privacy = 'public' OR users.id = :user_id ORDER BY created_at DESC", [
        'user_id' => $user['id']
    ])->fetchAll();
    $liked_posts = $db->query("SELECT post_id FROM likes WHERE user_id = :user_id", ['user_id' => $user['id']])->fetchAll(PDO::FETCH_COLUMN);
}

view($views[$role]['view'], [
    'title' => 'SubdiWise',
    'style' => $views[$role]['style'],
    'navlinks' => $views[$role]['navlinks'] ?? [],
    'posts' => $posts,
    'liked_posts' => $liked_posts,
    'current_user' => $user
]);