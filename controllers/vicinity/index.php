<?php

$user = $_SESSION['user'] ?? null;

view('pages/vicinity/index.php', [
    'title' => 'Vicinity Map',
    'style' => 'vicinity',
    'navlinks' => [
        ['url' => '/', 'text' => 'Home'],
        ['url' => '/dashboard', 'text' => 'Dashboard'],
        ['url' => '/vicinity', 'text' => 'Vicinity'],
        ['url' => '/transactions', 'text' => 'Transactions']
    ],
    'current_user' => $user
]);