<?= partial('head', ['title' => $title]) ?>
<?= style($style) ?>


<main class="landing">
    <?= partial('landing/nav') ?>
    <?= partial('landing/home') ?>
    <?= partial('landing/about') ?>
    <?= partial('landing/explore') ?>
    <?= partial('landing/directions') ?>
</main>

<?= script('landing') ?>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUE_qqLPIyEb1uGZeAx6asjCid3UDr22cY&callback=initMap" async defer></script> -->

<?= partial('foot') ?>