<?php

include '../config.php';
include '../db_connection.php';

// Query to fetch events
$sql = "SELECT id, name, description, coverPhoto FROM event";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/common.css">
    <script src="https://kit.fontawesome.com/620a552ea1.js" crossorigin="anonymous"></script>
    
    <title>Events List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<?php include_once '../navbar.php'; ?>

<h1>Upcoming Events</h1>

<?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Cover photo</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["name"]) ?></td>
                <td><?= $row["description"] ?></td>
                <td><?= htmlspecialchars($row["coverPhoto"]) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No events found.</p>
<?php endif; ?>
<?php include_once '../footer.php'; ?>

<?php $conn->close(); ?>


</body>
</html>
