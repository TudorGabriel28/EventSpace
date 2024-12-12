<?php

include '../config.php';
include '../db_connection.php';

$errorMessage = '';
$successMessage = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dateOfBirth = $_POST['dateOfBirth'];

    if($password !== $confirmPassword){
        $errorMessage = 'Passwords do not match';
    } else {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $errorMessage = "User with this email already exists";
        } else {
            $sql = "INSERT INTO user (firstName, lastName, email, password, dateOfBirth) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $dateOfBirth);
            if($stmt->execute() === TRUE) {
                $successMessage = "Account successfully created";
                header("Location: login.php");
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();

?>

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
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
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