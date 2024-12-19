<?php
session_start();
include '../config.php';
include '../db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Get the username
    $password = $_POST['password']; // Get the password

    // Query to fetch admin details from the database
    $stmt = $conn->prepare("SELECT id, password_hash FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the username exists in the database
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify the entered password with the hashed password in the database
        if (password_verify($password, $admin['password_hash'])) {
            // Set the session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $username;

            // Redirect to the admin dashboard
            header("Location: admin.php");
            exit();
        } else {
            // Password is incorrect
            $error = "Invalid credentials. Please try again.";
        }
    } else {
        // Username does not exist
        $error = "Invalid credentials. Please try again.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f8f8;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #dc3545;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
