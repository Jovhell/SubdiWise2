<?php

$db = new Database();
$currentUser = $_SESSION['user'];

$post_content = trim($_POST["edited-post-content"]);
$post_id = $_POST['post_id'];

$db->query("UPDATE posts SET content = :content WHERE author_id = :author_id AND id = :post_id", [
    'content' => $post_content,
    'author_id' => $currentUser['id'],
    'post_id' => $post_id,
]);

header("location:/");