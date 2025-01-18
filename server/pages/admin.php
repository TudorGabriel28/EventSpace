<?php
require_once '../config.php';
require_once '../db_connection.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController($conn);
$adminController->index();
?>