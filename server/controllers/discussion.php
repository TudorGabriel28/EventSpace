<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include_once(__DIR__ . "/../models/discussion.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$title = "Discussion";
$stylesheet = "discussion.css";

$forumDiscussionId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $commentContent = $_POST['comment'];
    if (addComment($conn, $commentContent, $forumDiscussionId, $userId)) {
        $successMessage = "Comment added successfully!";
    } else {
        $errorMessage = "Error: Could not add comment.";
    }
}

$discussion = getDiscussionDetails($conn, $forumDiscussionId);
$comments = getComments($conn, $forumDiscussionId);

?>