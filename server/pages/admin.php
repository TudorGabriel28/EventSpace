<?php
// Include database connection
include '../config.php';
include '../db_connection.php';

// Fetch users from the database
$users = [];
try {
    $query = "SELECT id, firstName, lastName, email, deleted_at FROM user";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching users: " . $e->getMessage());
}

// Fetch events from the database
$events = [];
try {
    $query = "SELECT id, name, description, deleted_at FROM event";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching events: " . $e->getMessage());
}

// Fetch forum discussions from the database
$forumDiscussions = [];
try {
    $query = "SELECT id, title, question, idUser, deleted_at FROM forumdiscussion";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $forumDiscussions[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching forum discussions: " . $e->getMessage());
}
?>

    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #1e1e1e;
            color: white;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #2c2c2c, #444);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            color: #ff8800;
            font-size: 2em;
        }

        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            width: 250px;
            background-color: #2c2c2c;
            height: calc(100% - 80px);
            padding: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            padding: 10px;
            display: block;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .sidebar ul li a:hover {
            background-color: #444;
        }

        .main-content {
            margin-left: 270px;
            padding: 30px;
        }

        .section {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #444;
        }

        table th {
            color: #ff8800;
        }

        table tr:hover {
            background-color: #444;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #ffa500;
        }

        .btn-edit:hover {
            background-color: #e67600;
        }

        .btn-delete {
            background-color: #d9534f;
        }

        .btn-delete:hover {
            background-color: #c9302c;
        }

        .btn-undo {
            background-color: #5bc0de;
        }

        .btn-undo:hover {
            background-color: #31b0d5;
        }

        .btn-permanent-delete {
            background-color: #ff0000;
        }

        .btn-permanent-delete:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <button class="logout-btn">Logout</button>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="#manage-users">Manage Users</a></li>
            <li><a href="#manage-events">Manage Events</a></li>
            <li><a href="#manage-forum">Manage Forum Questions</a></li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Manage Users -->
        <div id="manage-users" class="section">
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="edit.php?type=user&id=<?php echo $user['id']; ?>" class="action-btn btn-edit">Edit</a>
                                <?php if (empty($user['deleted_at'])): ?>
                                    <a href="delete.php?type=user&id=<?php echo $user['id']; ?>" class="action-btn btn-delete">Delete</a>
                                <?php else: ?>
                                    <a href="undo.php?type=user&id=<?php echo $user['id']; ?>" class="action-btn btn-undo">Undo</a>
                                    <a href="permanent_delete.php?type=user&id=<?php echo $user['id']; ?>" class="action-btn btn-permanent-delete">Permanent Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Manage Events -->
        <div id="manage-events" class="section">
            <h2>Manage Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['id']); ?></td>
                            <td><?php echo htmlspecialchars($event['name']); ?></td>
                            <td><?php echo htmlspecialchars($event['description']); ?></td>
                            <td>
                                <a href="edit.php?type=event&id=<?php echo $event['id']; ?>" class="action-btn btn-edit">Edit</a>
                                <?php if (empty($event['deleted_at'])): ?>
                                    <a href="delete.php?type=event&id=<?php echo $event['id']; ?>" class="action-btn btn-delete">Delete</a>
                                <?php else: ?>
                                    <a href="undo.php?type=event&id=<?php echo $event['id']; ?>" class="action-btn btn-undo">Undo</a>
                                    <a href="permanent_delete.php?type=event&id=<?php echo $event['id']; ?>" class="action-btn btn-permanent-delete">Permanent Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Manage Forum Questions -->
        <div id="manage-forum" class="section">
            <h2>Manage Forum Questions</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Question</th>
                        <th>User ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forumDiscussions as $discussion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($discussion['id']); ?></td>
                            <td><?php echo htmlspecialchars($discussion['title']); ?></td>
                            <td><?php echo htmlspecialchars($discussion['question']); ?></td>
                            <td><?php echo htmlspecialchars($discussion['idUser']); ?></td>
                            <td>
                                <a href="edit.php?type=forum&id=<?php echo $discussion['id']; ?>" class="action-btn btn-edit">Edit</a>
                                <?php if (empty($discussion['deleted_at'])): ?>
                                    <a href="delete.php?type=forum&id=<?php echo $discussion['id']; ?>" class="action-btn btn-delete">Delete</a>
                                <?php else: ?>
                                    <a href="undo.php?type=forum&id=<?php echo $discussion['id']; ?>" class="action-btn btn-undo">Undo</a>
                                    <a href="permanent_delete.php?type=forum&id=<?php echo $discussion['id']; ?>" class="action-btn btn-permanent-delete">Permanent Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
