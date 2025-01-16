<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/event.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$eventData = getEventData($conn, $eventId);
$planningDetails = getPlanningDetails($conn, $eventId);
$errorMessage = '';
$subscriptionSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userId !== 0) {
    if (isset($_POST['subscribe'])) {
        list($errorMessage, $subscriptionSuccess, $showWaitlistButton) = handleSubscription($conn, $_POST, $userId);
    } elseif (isset($_POST['join-waitlist'])) {
        list($errorMessage, $subscriptionSuccess, $showWaitlistButton) = handleSubscription($conn, $_POST, $userId, true);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe']) && !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
}

$title = htmlspecialchars($eventData['name']);
$stylesheet = "event-details.css";
$script = "event-details.js";
?>
