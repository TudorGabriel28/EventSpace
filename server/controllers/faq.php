<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/faq.php");

$faqs = getFAQs($conn);

$title = "FAQs";
$stylesheet = "faq.css";
?>