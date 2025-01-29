<?
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubdiWise</title>
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SubdiWise</h1>
            <h2>Anami Homes Mactan</h2>
        </div>
        <form method="POST" action="./db/controller.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            <a href="" class="forgot-pass">Forgot Password?</a>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
