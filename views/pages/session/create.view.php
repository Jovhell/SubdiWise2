<?php require(base_path('views/partials/head.php')) ?>
<?= style($style) ?>

<div class="container">
    <div class="header">
        <h1>SubdiWise</h1>
        <h2>Anami Homes Mactan</h2>
    </div>
    <form method="POST" action="/login">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" required>
            <?php if(isset($errors['email'])): ?>
                <div class="error-message"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            <?php if(isset($errors['password'])): ?>
                <div class="error-message"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>
        <a href="" class="forgot-pass">Forgot Password?</a>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
<?php require base_path('views/partials/foot.php') ?>
