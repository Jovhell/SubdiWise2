<?php

$user = $_SESSION['user'] ?? null;

view('pages/transactions/index.php', [
    'title' => 'Transactions',
    'style' => 'transactions',
    'navlinks' => [
        ['url' => '/', 'text' => 'Home'],
        ['url' => '/dashboard', 'text' => 'Dashboard'],
        ['url' => '/vicinity', 'text' => 'Vicinity'],
        ['url' => '/transactions', 'text' => 'Transactions']
    ],
    'current_user' => $user
]);