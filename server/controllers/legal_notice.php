<?php
// controllers/legal_notice.php

include(__DIR__ . '/../config.php');
include(__DIR__ . '/../db_connection.php');
include(__DIR__ . '/../models/legal_notice.php');

// Fetch legal notices using the model
$legal_notices = getLegalNotices($conn);

$title = "Legal Notice";
$stylesheet = "../styles/legal-notice.css";
?>
