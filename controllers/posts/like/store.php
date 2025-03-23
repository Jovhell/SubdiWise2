<?php

$db = new Database();

$user_id = $_SESSION['user']['id'];
$post_id = $_POST['post_id'];
$isDislike = $_POST['isDislike'];

if($isDislike) {
    $db->query("DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id", [
        'user_id' => $user_id,
        'post_id' => $post_id
    ]);
    $db->query("UPDATE posts SET likes_count = likes_count - 1 WHERE id = :post_id", [
        'post_id' => $post_id
    ]);
} else {
    $db->query("INSERT INTO likes (user_id, post_id, time_created) VALUES (:user_id, :post_id, NOW())", [
        'user_id' => $user_id,
        'post_id' => $post_id
    ]);
    $db->query("UPDATE posts SET likes_count = likes_count + 1 WHERE id = :post_id", [
        'post_id' => $post_id
    ]);
}

header("location:/");
