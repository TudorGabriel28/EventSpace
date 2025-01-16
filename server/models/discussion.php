<?php
function getDiscussionDetails($conn, $forumDiscussionId) {
    $sql = "SELECT forumdiscussion.title, CONCAT(user.firstName, ' ', user.lastName) AS 'User', user.profilePicture, forumdiscussion.question
            FROM forumdiscussion 
            INNER JOIN user ON forumdiscussion.idUser = user.id
            WHERE forumdiscussion.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $forumDiscussionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $discussion = $result->fetch_assoc();
    $stmt->close();
    return $discussion;
}

function getComments($conn, $forumDiscussionId) {
    $sql = "SELECT CONCAT(user.firstName, ' ', user.lastName) AS 'User', user.profilePicture, forumcomment.content
            FROM forumcomment INNER JOIN user ON forumcomment.idUser = user.id
            WHERE forumcomment.idDiscussion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $forumDiscussionId);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
    }
    $stmt->close();
    return $comments;
}

function addComment($conn, $commentContent, $forumDiscussionId, $userId) {
    $sql = "INSERT INTO forumcomment (content, idDiscussion, idUser) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $commentContent, $forumDiscussionId, $userId);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}
?>