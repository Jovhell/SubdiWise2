<?php

$db = new Database();
$currentUser = $_SESSION['user'];

$post_content = trim($_POST["post-content"]);
$privacy = $_POST["privacy"] ?? "public";

$filePaths = [];
if (!empty($_FILES['file']['name'][0])) {
    $uploadDir = base_path("public/uploads/"); // Ensure this directory exists

    foreach ($_FILES['file']['name'] as $index => $fileName) {
        $tmpName = $_FILES['file']['tmp_name'][$index];
        $fileSize = $_FILES['file']['size'][$index];
        $fileType = $_FILES['file']['type'][$index];
        $fileError = $_FILES['file']['error'][$index];

        // Generate a unique file name to avoid overwriting
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid("img_", true) . "." . $fileExt;

        // Destination path
        $destination = $uploadDir . $newFileName;

        // File upload validation
        if ($fileError === 0) {
            if ($fileSize < 5 * 1024 * 1024) { // Limit to 5MB
                if (move_uploaded_file($tmpName, $destination)) {
                    $filePaths[] = $newFileName;
                    echo "Uploaded: " . $fileName . " -> " . $destination . "<br>";
                } else {
                    echo "Failed to upload " . $fileName . "<br>";
                    die();
                }
            } else {
                echo "File too large: " . $fileName . "<br>";
            }
        } else {
            echo "Error uploading " . $fileName . "<br>";
            die();
        }
    }
} else {
    echo "No files uploaded!";
}

$imagePaths = [];
if (!empty($_FILES['image']['name'][0])) {
    $uploadDir = base_path("public/uploads/"); // Ensure this directory exists

    foreach ($_FILES['image']['name'] as $index => $fileName) {
        $tmpName = $_FILES['image']['tmp_name'][$index];
        $fileSize = $_FILES['image']['size'][$index];
        $fileType = $_FILES['image']['type'][$index];
        $fileError = $_FILES['image']['error'][$index];

        // Generate a unique file name to avoid overwriting
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid("img_", true) . "." . $fileExt;

        // Destination path
        $destination = $uploadDir . $newFileName;

        // File upload validation
        if ($fileError === 0) {
            if ($fileSize < 5 * 1024 * 1024) { // Limit to 5MB
                if (move_uploaded_file($tmpName, $destination)) {
                    $imagePaths[] = $newFileName;
                    echo "Uploaded: " . $fileName . " -> " . $destination . "<br>";
                } else {
                    echo "Failed to upload " . $fileName . "<br>";
                    die();
                }
            } else {
                echo "File too large: " . $fileName . "<br>";
            }
        } else {
            echo "Error uploading " . $fileName . "<br>";
            die();
        }
    }
} else {
    echo "No files uploaded!";
}

$filePathsJson = json_encode($filePaths);
$imagePathsJson = json_encode($imagePaths);

$post_id = $db->query("INSERT INTO posts (author_id, content, files, images, privacy, created_at, likes_count, comments_count) VALUES (:author_id, :content, :files, :images, :privacy, NOW(), 0 , 0)", [
    'author_id' => $currentUser['id'],
    'content' => htmlspecialchars($post_content),
    'files' => $filePathsJson,
    'images' => $imagePathsJson,
    'privacy' => $privacy
])->lastInsertedId();

header("location:/");
