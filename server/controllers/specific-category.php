<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/event.php");
include(__DIR__ . "/../models/category.php");

$stylesheet = "specific-category.css";

$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : '';

if (empty($categoryId)) {
    header("Location: home.php");
    exit();
}

// Fetch category name
$categoryName = getCategoryNameById($conn, $categoryId);

// Fetch events for the specific category
$events = getEventsByCategory($conn, $categoryId);

?>