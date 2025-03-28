<?php

$user_id = routeParam('user_id');
$post_id = routeParam('post_id');

$user = $_SESSION['user'] ?? null;

$db = new Database();
$post = $db->query("SELECT users.id as user_id, posts.id as post_id, posts.*, users.* FROM posts INNER JOIN users ON posts.author_id = users.id WHERE posts.id = :post_id AND users.id = :user_id", [
    'user_id' => $user_id,
    'post_id' => $post_id
])->fetch();
$liked_posts = $db->query("SELECT post_id FROM likes WHERE user_id = :user_id", ['user_id' => $user['id']])->fetchAll(PDO::FETCH_COLUMN);

view('pages/post/index.php', [
    'title' => 'Post',
    'style' => 'post',
    'current_user' => $user,
    'post' => $post,
    'liked_posts' => $liked_posts,
]);