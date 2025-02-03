<?php

function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function base_path($path = "") {
    return __DIR__ . '/' . $path;
}

function view($path = "", $data = []) {
    extract($data);
    require(base_path('views/' . $path));
}

function login($user) {
    $_SESSION['user'] = [
        'email' => $user['email'],
        'role' => $user['role']
    ];

    session_regenerate_id();
}

function logout() {
    $_SESSION = [];
    session_destroy();

    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}