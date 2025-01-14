<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include_once(__DIR__ . "/../models/forum.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$title = "Forum";
$stylesheet = "forum.css";

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new-discussion'])) {
    $title = $_POST['title'];
    $question = $_POST['question'];
    if (addDiscussion($conn, $title, $question, $userId)) {
        $successMessage = "Discussion added successfully!";
        header("Location: forum.php");
        exit();
    } else {
        $errorMessage = "Error: Could not add discussion.";
    }
}

$discussions = getDiscussions($conn);

include '../views/forum.php';
?>