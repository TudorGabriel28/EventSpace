<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/terms.php");

$terms = getTermsAndConditions($conn);

$title = "Terms and Conditions";
$stylesheet = "terms.css";
