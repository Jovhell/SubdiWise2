<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (isset($title)): ?>
    <title><?php echo $title ?></title>
    <?php endif; ?>

    <link rel="stylesheet" href="styles/index.css">

    <?php if (isset($style)): ?>
    <link rel="stylesheet" href="styles/<?php echo $style ?>">
    <?php endif; ?>
</head>
<body>