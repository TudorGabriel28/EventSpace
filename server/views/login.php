<?php include "../controllers/login.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventSpace Login</title>
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/authentication.css">
</head>

<body>
    <main>
        <div class="container">
            <div class="image-section">
                <a href="home.php" class="navbar-logo">
                    <img src="../assets/logo-black.png" alt="Logo">
                </a>
            </div>

            <form class="form-section" action="../controllers/login.php" method="POST">
                <h1>Sign in to EventSpace</h1>

                <input type="email" name="email" placeholder="Email" class="input" required>
                <input type="password" name="password" placeholder="Password" class="input" required>
                <p>Don’t have an account? Register <a href="register.php">here</a> </p>
                <button type="submit" class="btn btn-primary">Sign in</button>

            </form>
        </div>
    </main>
</body>

</html>