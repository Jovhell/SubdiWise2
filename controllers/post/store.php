<?php

$db = new Database();
$currentUser = $_SESSION['user'];

$post_content = trim($_POST["post-content"]);
$privacy = $_POST["privacy"] ?? "public";

$filePaths = [];
if (!empty($_FILES["files"]["name"][0])) {
    $uploadDir = "uploads/";
    foreach ($_FILES["files"]["name"] as $index => $fileName) {
        $fileTmpName = $_FILES["files"]["tmp_name"][$index];
        $filePath = $uploadDir . basename($fileName);
        
        if (move_uploaded_file($fileTmpName, $filePath)) {
            $filePaths[] = $filePath;
        }
    }
}

$imagePaths = [];
if (!empty($_FILES["images"]["name"][0])) {
    $uploadDir = "uploads/";
    foreach ($_FILES["images"]["name"] as $index => $imageName) {
        $imageTmpName = $_FILES["images"]["tmp_name"][$index];
        $imagePath = $uploadDir . basename($imageName);
        
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $imagePaths[] = $imagePath; 
        }
    }
}

$filePathsJson = json_encode($filePaths);
$imagePathsJson = json_encode($imagePaths);

$post_id = $db->query("INSERT INTO posts (author_id, content, files, images, privacy, created_at, likes_count, comments_count) VALUES (:author_id, :content, :files, :images, :privacy, NOW(), 0 , 0)", [
    'author_id' => $currentUser['id'],
    'content' => $post_content,
    'files' => $filePathsJson,
    'images' => $imagePathsJson,
    'privacy' => $privacy
])->lastInsertedId();

header("location:/");
