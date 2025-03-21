<?php require(base_path('views/partials/head.php')) ?>
<?= style($style) ?>

<div class="container">
    <div class="login">
        <a href="/" class="brand">
            <div class="logo">
                <?php require('assets/Logo.svg') ?>
            </div>
            <div class="name">SubdiWise</div>
        </a>
        <div class="form-area">
            <div class="header">
                <h1>Welcome Back</h1>
                <p>Sign in to your Anami Homes Resident Account</p>
            </div>
            <form method="POST" action="/login" id="login-form">
                <div class="input-group">
                    <?php if(isset($errors['email'])): ?>
                        <label for="email" class="error-message"><?= $errors['email'] ?></label>
                    <?php else: ?>
                        <label for="email">Email</label>
                    <?php endif; ?>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Enter email"
                        value="<?php echo $form_data['email'] ?? '' ?>"
                        required>
                </div>
                <div class="input-group">
                    <?php if(isset($errors['password'])): ?>
                        <label for="password" class="error-message"><?= $errors['password'] ?></label>
                    <?php else: ?>
                        <label for="password">Password</label>
                    <?php endif; ?>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter password" 
                        value="<?php echo $form_data['password'] ?? '' ?>"
                        required>
                    <button type="button" onclick="this.textContent = (this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password') === 'password' ? 'Show' : 'Hide'">
                        Show
                    </button>
                </div>
                <a href="">Forgot Password?</a>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    <div class="banner">
        <img src="assets/login-banner.png" alt="login banner">
    </div>
</div>

<?= script('login') ?>
<?php require base_path('views/partials/foot.php') ?>
