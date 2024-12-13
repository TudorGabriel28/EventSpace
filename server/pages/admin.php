<?php
// Include database connection
include '../config.php';
include '../db_connection.php';
?>


    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1e1e1e; /* Dark grey background */
            color: #ffffff; /* White text for readability */
        }

        /* Dashboard header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: linear-gradient(135deg, #2c2c2c, #444);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            font-size: 2em;
            margin: 0;
            color: #ff8800; /* Vibrant orange for emphasis */
        }

        .header .logout-btn {
            background-color: #ff8800;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .header .logout-btn:hover {
            background-color: #e67600;
        }

        /* Sidebar navigation */
        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            width: 250px;
            height: calc(100% - 80px);
            background-color: #2c2c2c;
            padding: 20px 10px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 1em;
            padding: 10px 20px;
            display: block;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #444;
        }

        /* Main content area */
        .main-content {
            margin-left: 270px;
            padding: 30px;
        }

        .section {
            background: #2e2e2e;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .section h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #ff8800;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #444;
        }

        .table th {
            background-color: #3a3a3a;
            color: #ff8800;
        }

        .table tr:hover {
            background-color: #3a3a3a;
        }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s;
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

        .btn-add {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
        }

        .btn-add:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Admin Dashboard</h1>
        <button class="logout-btn">Logout</button>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="#manage-users">Manage Users</a></li>
            <li><a href="#manage-events">Manage Events</a></li>
            <li><a href="#manage-forum">Manage Forum Questions</a></li>
            <li><a href="#settings">Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Manage Users -->
        <div id="manage-users" class="section">
            <h2>Manage Users</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td>User</td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn-add">Add New User</button>
        </div>

        <!-- Manage Events -->
        <div id="manage-events" class="section">
            <h2>Manage Events</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Host</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <tr>
                        <td>101</td>
                        <td>Art Expo</td>
                        <td>2024-12-15</td>
                        <td>Jane Smith</td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn-add">Add New Event</button>
        </div>

        <!-- Manage Forum Questions -->
        <div id="manage-forum" class="section">
            <h2>Manage Forum Questions</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Asked By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <tr>
                        <td>501</td>
                        <td>How do I host an event?</td>
                        <td>Alex Brown</td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>
