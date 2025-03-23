<nav>
    <a href="/" class="brand">
        <div class="logo">
            <?php require('assets/Logo.svg') ?>
        </div>
        <div class="name">SubdiWise</div>
    </a>
    <?php foreach ($navlinks as $link): ?>
        <a href="<?= $link['url'] ?>" class="<?= str_starts_with($_SERVER['REQUEST_URI'], $link['url']) ? 'active-link' : '' ?>">
            <?php require('assets/nav-icons/'. (str_starts_with($_SERVER['REQUEST_URI'], $link['url']) ? 'Active_' : '') . $link['text'] .'_Icon.svg') ?>
            <?= $link['text'] ?>
        </a>
    <?php endforeach; ?>
    <?php require base_path('views/partials/logout.php') ?>
    
    <div class="profile">
        <div class="display-picture">
            <img src="<?= profile_pic($current_user['profile_picture']) ?>" alt="">
        </div>
        <div class="details">
            <div class="display-name"><?= $current_user['fname'] . ' ' . $current_user['lname'] ?></div>
            <div class="role"><?= ucfirst($current_user['role']) ?></div>
        </div>
        <div class="menu">
            <?php require('assets/Ellipsis.svg') ?>
        </div>
    </div>
</nav>