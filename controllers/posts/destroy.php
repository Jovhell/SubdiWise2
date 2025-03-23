<?php

$db = new Database();
$currentUser = $_SESSION['user'];

$post_id = $_POST['post_id'];


$db->query("DELETE FROM posts WHERE author_id = :author_id AND id = :post_id", [
    'author_id' => $currentUser['id'],
    'post_id' => $post_id,
]);

header("location:/");