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

function style($path) {
    $fullPath = base_path("styles/{$path}.css");

    if (!$path || !file_exists($fullPath)) {
        return '';
    }

    ob_start();
    require $fullPath;
    $css = ob_get_clean();

    return "<style>\n{$css}\n</style>";
}

function script($name) {
    $fullPath = base_path("scripts/{$name}.js");

    if(!$name || !file_exists($fullPath)) {
        return "";
    }

    ob_start();
    require $fullPath;
    $js = ob_get_clean();

    return "<script>\n{$js}\n</script>";
}

function partial($name, $data = []) {
    $fullPath = base_path("views/partials/{$name}.php");

    if (file_exists($fullPath)) {
        extract($data);
        require $fullPath;
    }
}

function login($user) {
    $_SESSION['user'] = $user;

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

function timeAgo($datetime) {
    date_default_timezone_set('Asia/Manila');
    $timestamp = strtotime($datetime);
    if (!$timestamp) return "Invalid date";

    $now = time();
    $diff = $now - $timestamp;

    $units = [
        "year" => 31536000,
        "month" => 2592000,
        "week" => 604800,
        "day" => 86400,
        "hour" => 3600,
        "minute" => 60,
        "second" => 1
    ];

    foreach ($units as $unit => $value) {
        if ($diff >= $value) {
            $count = floor($diff / $value);
            return $count === 1 ? "1 $unit ago" : "$count {$unit}s ago";
        }
    }
    
    return "just now";
}
