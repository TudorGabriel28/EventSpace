<?php
// Include database connection
include '../config.php';
include '../db_connection.php';

// Fetch users
$users = [];
try {
    $query = "SELECT id, firstName, lastName, email FROM user";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching users: " . $e->getMessage());
}

// Fetch events
$events = [];
try {
    $query = "SELECT id, name, description FROM event";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching events: " . $e->getMessage());
}

// Fetch forum discussions
$forums = [];
try {
    $query = "SELECT id, title, question, idUser FROM forumdiscussion";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $forums[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching forums: " . $e->getMessage());
}
?>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafc;
            color: #333;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            color: black;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .header img {
            height: 50px;
        }
        .header h1 {
            margin: 0;
            font-size: 1.8em;
            text-align: center;
            flex-grow: 1;
            font-weight: 500;
            color: black;
        }
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 240px;
            height: 100%;
            background-color: #f4f5f7;
            padding-top: 20px;
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            display: block;
            color: #333;
            text-decoration: none;
            padding: 15px 20px;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #e7f3ff;
            color: #007bff;
        }
        .content {
            margin-left: 260px;
            padding: 100px 20px 20px;
        }
        .section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 8px;
            overflow: hidden;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }
        table th {
            background-color: #f0f2f5;
            color: #333;
            font-weight: 500;
        }
        table tr:nth-child(odd) {
            background-color: #f9fafc;
        }
        table tr:hover {
            background-color: #e7f3ff;
        }
        table td[contenteditable="true"] {
            border: 1px solid #007bff;
            background-color: #e7f3ff;
        }
        button {
            margin: 3px;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.9em;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .edit-btn { background: #ff9800; color: white; }
        .save-btn { background: #28a745; color: white; }
        .cancel-btn { background: #007bff; color: white; }
        .delete-btn { background: #dc3545; color: white; }
        button:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .save-btn, .cancel-btn { display: none; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="../assets/logo-black.png" alt="Logo">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#users">Manage Users</a>
        <a href="#events">Manage Events</a>
        <a href="#forums">Manage Forum Questions</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Users Section -->
        <div id="users" class="section">
            <h2>Manage Users</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td contenteditable="false"><?php echo $user['firstName']; ?></td>
                    <td contenteditable="false"><?php echo $user['lastName']; ?></td>
                    <td contenteditable="false"><?php echo $user['email']; ?></td>
                    <td>
                        <button class="edit-btn" onclick="editRow(this)">Edit</button>
                        <button class="save-btn" onclick="saveRow(this, 'user')">Save</button>
                        <button class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                        <button class="delete-btn" onclick="confirmDelete('<?php echo $user['id']; ?>', 'user')">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Events Section -->
        <div id="events" class="section">
            <h2>Manage Events</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo $event['id']; ?></td>
                    <td contenteditable="false"><?php echo $event['name']; ?></td>
                    <td contenteditable="false"><?php echo $event['description']; ?></td>
                    <td>
                        <button class="edit-btn" onclick="editRow(this)">Edit</button>
                        <button class="save-btn" onclick="saveRow(this, 'event')">Save</button>
                        <button class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                        <button class="delete-btn" onclick="confirmDelete('<?php echo $event['id']; ?>', 'event')">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Forums Section -->
        <div id="forums" class="section">
            <h2>Manage Forum Questions</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Question</th>
                    <th>User ID</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($forums as $forum): ?>
                <tr>
                    <td><?php echo $forum['id']; ?></td>
                    <td contenteditable="false"><?php echo $forum['title']; ?></td>
                    <td contenteditable="false"><?php echo $forum['question']; ?></td>
                    <td><?php echo $forum['idUser']; ?></td>
                    <td>
                        <button class="edit-btn" onclick="editRow(this)">Edit</button>
                        <button class="save-btn" onclick="saveRow(this, 'forum')">Save</button>
                        <button class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                        <button class="delete-btn" onclick="confirmDelete('<?php echo $forum['id']; ?>', 'forum')">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <script>
        let originalData = {};

        function editRow(btn) {
            const row = btn.parentElement.parentElement;
            originalData[row] = [...row.cells].map(cell => cell.innerText);

            [...row.cells].forEach((cell, index) => {
                if (index > 0 && index < row.cells.length - 1) {
                    cell.contentEditable = "true";
                    cell.style.border = "1px solid #007bff";
                    cell.style.backgroundColor = "#e7f3ff";
                }
            });
            toggleButtons(btn, true);
        }

        function saveRow(btn, type) {
            const row = btn.parentElement.parentElement;
            const data = [...row.cells].slice(1, -1).map(cell => cell.innerText);
            const id = row.cells[0].innerText;

            const updateData = type === "user"
                ? { firstName: data[0], lastName: data[1], email: data[2] }
                : type === "event"
                ? { name: data[0], description: data[1] }
                : { title: data[0], question: data[1] };

            fetch("edit.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ type, id, data: updateData }),
            })
                .then(response => response.json())
                .then(response => {
                    if (response.status === "success") {
                        alert("Data updated successfully!");

                        // Revert cell styles to normal
                        [...row.cells].forEach((cell, index) => {
                            if (index > 0 && index < row.cells.length - 1) {
                                cell.contentEditable = "false";
                                cell.style.border = "none";
                                cell.style.backgroundColor = "transparent";
                            }
                        });

                        toggleButtons(btn, false);
                    }
                });
        }

        function confirmDelete(id, type) {
            if (confirm("Are you sure you want to delete this record?")) {
                fetch("delete.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ type, id }),
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response.status === "success") {
                            alert("Record deleted successfully!");
                            location.reload();
                        }
                    });
            }
        }

        function cancelEdit(btn) {
            const row = btn.parentElement.parentElement;
            [...row.cells].forEach((cell, index) => {
                if (index > 0 && index < row.cells.length - 1) {
                    cell.innerText = originalData[row][index];
                    cell.contentEditable = "false";
                    cell.style.border = "none";
                    cell.style.backgroundColor = "transparent";
                }
            });
            toggleButtons(btn, false);
        }

        function toggleButtons(btn, isEditing) {
            const buttons = btn.parentElement.children;
            buttons[0].style.display = isEditing ? "none" : "inline";
            buttons[1].style.display = isEditing ? "inline" : "none";
            buttons[2].style.display = isEditing ? "inline" : "none";
        }
    </script>
</body>
</html>
