<?php require(base_path('views/partials/head.php')) ?>
<?= style($style) ?>

<main class="home">
    <div class="left-panel">
        <?php require base_path('views/partials/nav.php') ?>
    </div>
    <div class="primary-screen">
        <?php require base_path('views/partials/feed.php') ?>
    </div>
    <div class="secondary-screen">
        
    </div>
</main>

<?= script('feed') ?>
<?php require base_path('views/partials/foot.php') ?>

