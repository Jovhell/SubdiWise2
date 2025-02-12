<?= partial('head', ['title' => $title]) ?>
<?= style($style) ?>

<main class="landing">
    <?= partial('landing/nav') ?>
    <?= partial('landing/home') ?>
    <?= partial('landing/about') ?>
    <?= partial('landing/explore') ?>
</main>

<?= script('landing') ?>

<?= partial('foot') ?>