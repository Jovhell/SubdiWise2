<?php

$user = $_SESSION['user'] ?? null;

view('pages/dashboard/index.php', [
    'title' => 'Dashboard',
    'style' => 'dashboard',
    'navlinks' => [
        ['url' => '/', 'text' => 'Home'],
        ['url' => '/dashboard', 'text' => 'Dashboard'],
        ['url' => '/vicinity', 'text' => 'Vicinity'],
        ['url' => '/transactions', 'text' => 'Transactions']
    ],
    'current_user' => $user
]);