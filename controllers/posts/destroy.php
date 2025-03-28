<?php

$db = new Database();
$currentUser = $_SESSION['user'];

$post_id = $_POST['post_id'];

$attachments = $db->query("SELECT images, files FROM posts WHERE id = :post_id", [
    'post_id' => $post_id
])->fetch();

$attachmentsPaths = [];

foreach(json_decode($attachments['images']) as $image) {
    array_push($attachmentsPaths, $image);
}

foreach(json_decode($attachments['files']) as $file) {
    array_push($attachmentsPaths, $file);
}

foreach($attachmentsPaths as $path) {
    unlink(base_path("public/uploads/" . $path));
}

$db->query("DELETE FROM posts WHERE author_id = :author_id AND id = :post_id", [
    'author_id' => $currentUser['id'],
    'post_id' => $post_id,
]);

header("location:/");