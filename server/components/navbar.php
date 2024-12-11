<?php
session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventSpace Navbar</title>
</head>
<body>
    <nav class="navbar">
        <a href="home.php" class="navbar-logo">
            <img src="../assets/logo-black.png" alt="Logo">
        </a>
        <form class="navbar-search" action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search for an Event">
            <button type="submit" class="search-button">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
        <ul class="navbar-links">
            <li><a href="about.php">About Us</a></li>
            <li><a href="faq.php">FAQs</a></li>
            <li><a href="forum.php">Forum</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="navbar-buttons">
            <button class="btn">Host an Event</button>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="logout.php" method="POST" style="display:inline;">
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            <?php else: ?>
                <button class="btn btn-primary" onclick="window.location.href='login.php'">Login</button>
            <?php endif; ?>
        </div>
    </nav>
</body>
</html>