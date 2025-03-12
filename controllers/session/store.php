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
    return view('pages/session/create.view.php', [
        'title' => 'Login',
        'style' => 'login',
        'errors' => $errors,
        'form_data' => [
            'email' => $email,
            'password' => $password
        ]
    ]);
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->fetch();

if(!$user) {
    $errors['email'] = 'User not found';
} elseif(!password_verify($password, $user['password'])) {
    $errors['password'] = "Password is incorrect";
}

if(!empty($errors)) {
    return view('pages/session/create.view.php', [
        'title' => 'Login',
        'style' => 'login',
        'errors' => $errors,
        'form_data' => [
            'email' => $email,
            'password' => $password
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