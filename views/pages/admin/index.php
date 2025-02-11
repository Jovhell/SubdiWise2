<?php require(base_path('views/partials/head.php')) ?>
<?= style($style) ?>

<main>
    <div class="left-panel">
        <?php require base_path('views/partials/nav.php') ?>
    </div>
    <div class="content">
        <h1>Admin Page</h1>
        <p>Welcome, Admin!</p>
        <?php require base_path('views/partials/logout.php') ?>
    </div>
</main

<?php require base_path('views/partials/foot.php') ?>

