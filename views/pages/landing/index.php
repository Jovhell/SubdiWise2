<?= partial('head', ['title' => $title]) ?>
<?= style($style) ?>

<main class="landing">
    <?= partial('landing/nav') ?>
    <?= partial('landing/home') ?>
</main>

<?= partial('foot') ?>