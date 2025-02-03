<nav>
    <a href="/" class="brand">
        <div class="logo">
            
        </div>
        <div class="name">SubdiWise</div>
    </a>
    <?php foreach ($navlinks as $link): ?>
        <a href="<?= $link['url'] ?>">
            <?= $link['text'] ?>
        </a>
    <?php endforeach; ?>
</nav>