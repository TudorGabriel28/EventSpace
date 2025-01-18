<?php
include_once(__DIR__ . "/../config.php");
include_once(__DIR__ . "/../db_connection.php");
include_once(__DIR__ . "/../models/admin.php");

try {
    $users = getUsers($conn);
    $pendingEvents = getPendingEvents($conn);
    $approvedEvents = getApprovedEvents($conn);
    $forums = getForumDiscussions($conn);
    
    $title = "Admin Dashboard - EventSpace";
    $stylesheet = "admin.css";
    
} catch (Exception $e) {
    die($e->getMessage());
}
?>