<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../db_connection.php');
include(__DIR__ . '/../models/category.php');

// Fetch categories using the model
$categories = getCategories($conn);

$title = "Host Event";
$stylesheet = "host.css";
?>
