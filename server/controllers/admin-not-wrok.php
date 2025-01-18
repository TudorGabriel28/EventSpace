<?php
include(__DIR__ . "/../config.php");
include(__DIR__ . "/../db_connection.php");
include(__DIR__ . "/../models/user.php");
include(__DIR__ . "/../models/event.php");
include(__DIR__ . "/../models/forum.php");

$users = getUsers($conn);
$pendingEvents = getPendingEvents($conn);
$approvedEvents = getApprovedEvents($conn);
$forums = getForumDiscussions($conn);

?>