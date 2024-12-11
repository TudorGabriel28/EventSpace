<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventSpace Navbar</title>
    <link rel="stylesheet" href="styles.css">
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
            <li><a href="#">About Us</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Forum</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div class="navbar-buttons">
            <button class="btn">Host an Event</button>
            <button class="btn btn-primary">Login</button>
        </div>
    </nav>
</body>
</html>