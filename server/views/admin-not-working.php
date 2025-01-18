<?php
include "../controllers/admin.php";
// include_once '../components/header.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EventSpace</title>
    <link rel="stylesheet" href="../styles/admin.css">
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

    <div class="sidebar">
        <a href="#pending-events" class="nav-link">Pending Events</a>
        <a href="#approved-events" class="nav-link">Approved Events</a>
        <a href="#users" class="nav-link">Manage Users</a>
        <a href="#forums" class="nav-link">Manage Forum Questions</a>
    </div>

    <div class="content">
        <?php include '../components/admin/pending-events.php'; ?>
        <?php include '../components/admin/approved-events.php'; ?>
        <?php include '../components/admin/users.php'; ?>
        <?php include '../components/admin/forums.php'; ?>
    </div>

    <script src="../server/scripts/admin.js"></script>
</body>
</html>