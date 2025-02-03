<?php

$db = new Database();

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if(!Validator::email($email)) {
    $errors['email'] = 'Email is invalid';
}

if(!Validator::string($password)) {
    $errors['password'] = 'Password invalid';
}

if(!empty($errors)) {
    return view('session/create.view.php', [
        'title' => 'Login',
        'style' => 'login.css',
        'errors' => $errors
    ]);
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->fetch();

if(!$user) {
    return view('session/create.view.php', [
        'title' => 'Login',
        'style' => 'login.css',
        'errors' => [
            'email' => 'User not found'
        ]
    ]);
}

if(!password_verify($password, $user['password'])) {
    return view('session/create.view.php', [
        'title' => 'Login',
        'style' => 'login.css',
        'errors' => [
            'password' => 'Password is incorrect'
        ]
    ]);
}

login([
    'id' => $user['id'],
    'email' => $user['email'],
    'role' => $user['role']
]);

header('Location: /');
exit();