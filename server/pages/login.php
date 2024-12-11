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
    <div class="container">
        <div class="image-section">
            <a href="home.php" class="navbar-logo">
                <img src="../assets/logo-black.png" alt="Logo">
            </a>
        </div>
        
        <form class="form-section" action="login.php" method="POST">
            <h1>Sign in to EventSpace</h1>
            
                <input type="email" name="email" placeholder="Email" class="input" required>
                <input type="password" name="password" placeholder="Password" class="input" required>
                <p>Don’t have an account? Register <a href="register.php">here</a> </p>
                <button type="submit" class="btn btn-primary">Sign in</button>
            
        </form>
    </div>
</body>
</html>


    <?php

    include '../config.php';
    include '../db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("SELECT id, password FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                session_start();
                $_SESSION['user_id'] = $id;
                header("Location: home.php");
                exit();
            } else {
                echo "<p>Invalid email or password</p>";
            }
        } else {
            echo "<p>Invalid email or password</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>