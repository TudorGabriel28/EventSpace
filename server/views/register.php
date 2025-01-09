<?php include "../controllers/register.php"; ?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="../styles/authentication.css">
    <link rel="stylesheet" href="../styles/common.css">
</head>
<main>
    <div class="container">

        <div class="image-section">
            <a href="home.php" class="navbar-logo">
                <img src="../assets/logo-black.png" alt="Logo">
            </a>
        </div>

        <div class="form-section">
            <h2>Create an account</h2>
            <form method="POST" action="#">
                <div class="name-row">
                    <input type="text" name="firstName" placeholder="First Name" required>
                    <input type="text" name="lastName" placeholder="Last Name" required>
                </div>
                <input type="date" name="dateOfBirth" placeholder="Birthday" required>
                <input type="email" name="email" placeholder="Email" required>
                <div class="password-row">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="password-row">
                    <input type="password" id="confirmPassword" name="confirmPassword"
                        placeholder="Confirm your password" required>
                </div>
                <div class="password-row">
                    <p id="passwordError" style="color: red;"></p>
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
            <?php if ($errorMessage): ?>
                <p class="error" style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <?php if ($successMessage): ?>
                <p class="success" style="color: green;"><?php echo $successMessage; ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        var passwordError = document.getElementById('passwordError');

        var passwordPattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$";

        if (!passwordPattern.test(password)) {
            e.preventDefault();
            passwordError.textContent = 'Password must be at least 8 characters long, contain one uppercase letter, and one special character.';
        } else if (password !== confirmPassword) {
            e.preventDefault();
            passwordError.textContent = 'Passwords do not match.';
        } else {
            passwordError.textContent = '';
        }
    });
</script>

</body>

</html>