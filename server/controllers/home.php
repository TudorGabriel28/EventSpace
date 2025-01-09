<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/event.php");
include(__DIR__ . "/../models/category.php");

$events = getEvents($conn);
$categories = getCategories($conn);

$title = "Home";
$stylesheet = "home.css";

?>