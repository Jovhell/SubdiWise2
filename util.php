<?php

function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function base_path($path) {
    return __DIR__ . '/' . $path;
}

function view($path, $data = []) {
    extract($data);

    require base_path('views/' . $path);
}

function login($user) {
    $_SESSION['user'] = [
        'email' => $user['email'],
        'role' => $user['role']
    ];
}