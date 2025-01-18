<?php
// views/admin.php
include_once("../controllers/admin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../styles/<?php echo $stylesheet; ?>">
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <!-- Header -->
    <div class="header">
        <img src="../assets/logo-black.png" alt="Logo">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#pending-events" class="nav-link">Pending Events</a>
        <a href="#approved-events" class="nav-link">Approved Events</a>
        <a href="#users" class="nav-link">Manage Users</a>
        <a href="#forums" class="nav-link">Manage Forum Questions</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Pending Events Section -->
        <?php include_once '../components/pending-events.php'; ?>

        <!-- Approved Events Section -->
        <?php include_once '../components/approved-events.php'; ?>

        <!-- Users Section -->
        <?php include_once '../components/users.php'; ?>

        <!-- Forums Section -->
        <?php include_once '../components/forums.php'; ?>
    </div>

    <script src="../scripts/admin.js"></script>
</body>
</html>