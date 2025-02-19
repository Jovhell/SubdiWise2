<?php
// header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: *"); // Allow cross-origin access if needed

$jsonFilePath = __DIR__ . '/../../data/places.json';

if (file_exists($jsonFilePath)) {
    echo file_get_contents($jsonFilePath);
} else {
    echo json_encode(["error" => "File not found"]);
}
?>
