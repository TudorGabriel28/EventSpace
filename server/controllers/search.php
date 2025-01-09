<?php

include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/event.php");
include(__DIR__ . "/../models/category.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';


// Redirect to home page if search parameter is empty
if (empty($search)) {
    header("Location: home.php");
    exit();
}



$events = getEvents($conn);
$categories = getCategories($conn);

$title = "Search";
$stylesheet = "search.css";

?>