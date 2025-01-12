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

// Fetch pending events
$pendingEvents = [];
try {
    $query = "SELECT id, name, description, coverPhoto FROM event WHERE isApproved = 0";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pendingEvents[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching pending events: " . $e->getMessage());
}

// Fetch approved events
$approvedEvents = [];
try {
    $query = "SELECT id, name, description FROM event WHERE isApproved = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $approvedEvents[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching approved events: " . $e->getMessage());
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EventSpace</title>
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
            transition: transform 0.3s ease;
        }
        .sidebar a {
            display: block;
            color: #333;
            text-decoration: none;
            padding: 15px 20px;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-left: 4px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #e7f3ff;
            color: #007bff;
            border-left-color: #007bff;
        }
        .content {
            margin-left: 260px;
            padding: 100px 20px 20px;
            transition: margin-left 0.3s ease;
        }
        .section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .section.visible {
            opacity: 1;
            transform: translateY(0);
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
            transition: background-color 0.3s ease;
        }
        table th {
            background-color: #f0f2f5;
            color: #333;
            font-weight: 500;
        }
        table tr:nth-child(odd) {
            background-color: #f9fafc;
        }
        table tr {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        table tr:hover {
            background-color: #e7f3ff;
            transform: scale(1.005);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        table td[contenteditable="true"] {
            border: 1px solid #007bff;
            background-color: #e7f3ff;
            position: relative;
        }
        table td[contenteditable="true"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }
        button {
            margin: 3px;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.9em;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        button:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        button:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        .edit-btn { background: #ff9800; color: white; }
        .save-btn { background: #28a745; color: white; }
        .cancel-btn { background: #007bff; color: white; }
        .delete-btn { background: #dc3545; color: white; }
        .approve-btn { background: #28a745; color: white; }
        .reject-btn { background: #dc3545; color: white; }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        button:active {
            transform: translateY(0);
        }
        .save-btn, .cancel-btn { display: none; }
        .event-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 4px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .event-image:hover {
            transform: scale(1.1);
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 1;
            }
            20% {
                transform: scale(25, 25);
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 25px;
            background: #333;
            color: white;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <!-- Header -->
    <div class="header">
        <img src="../assets/logo-black.png" alt="Logo">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#pending-events" class="nav-link">Pending Events</a>
        <a href="#approved-events" class="nav-link">Approved Events</a>
        <a href="#users" class="nav-link">Manage Users</a>
        <a href="#forums" class="nav-link">Manage Forum Questions</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Pending Events Section -->
        <div id="pending-events" class="section">
            <h2>Pending Events</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Cover Photo</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($pendingEvents as $event): ?>
                <tr>
                    <td><?php echo $event['id']; ?></td>
                    <td><?php echo $event['name']; ?></td>
                    <td><?php echo $event['description']; ?></td>
                    <td><img src="<?php echo $event['coverPhoto']; ?>" alt="Event Cover" class="event-image"></td>
                    <td>
                        <button class="approve-btn" onclick="approveEvent('<?php echo $event['id']; ?>')">Approve</button>
                        <button class="reject-btn" onclick="rejectEvent('<?php echo $event['id']; ?>')">Reject</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Approved Events Section -->
        <div id="approved-events" class="section">
            <h2>Approved Events</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($approvedEvents as $event): ?>
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
                            <button class="delete-btn"
                                onclick="confirmDelete('<?php echo $user['id']; ?>', 'user')">Delete</button>
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
                            <button class="delete-btn"
                                onclick="confirmDelete('<?php echo $forum['id']; ?>', 'forum')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <script>
        // Store original data for canceling edits
        let originalData = {};

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Show sections with animation
            showSections();
            // Set up navigation
            setupNavigation();
            // Set up image preview
            setupImagePreviews();
        });

        // Function to handle section visibility animations
        function showSections() {
            const sections = document.querySelectorAll('.section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            sections.forEach(section => observer.observe(section));
        }

        // Function to set up navigation highlighting
        function setupNavigation() {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('.section');

            // Highlight active section on scroll
            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.pageYOffset >= sectionTop - 200) {
                        current = '#' + section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === current) {
                        link.classList.add('active');
                    }
                });
            });

            // Smooth scroll to section
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.getAttribute('href');
                    const targetSection = document.querySelector(targetId);
                    targetSection.scrollIntoView({ behavior: 'smooth' });
                });
            });
        }

        // Function to set up image previews
        function setupImagePreviews() {
            const images = document.querySelectorAll('.event-image');
            images.forEach(img => {
                img.addEventListener('click', () => {
                    const modal = document.createElement('div');
                    modal.style.position = 'fixed';
                    modal.style.top = '0';
                    modal.style.left = '0';
                    modal.style.width = '100%';
                    modal.style.height = '100%';
                    modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
                    modal.style.display = 'flex';
                    modal.style.justifyContent = 'center';
                    modal.style.alignItems = 'center';
                    modal.style.zIndex = '9999';

                    const modalImg = document.createElement('img');
                    modalImg.src = img.src;
                    modalImg.style.maxWidth = '90%';
                    modalImg.style.maxHeight = '90%';
                    modalImg.style.objectFit = 'contain';
                    modalImg.style.borderRadius = '8px';

                    modal.appendChild(modalImg);
                    document.body.appendChild(modal);

                    modal.addEventListener('click', () => {
                        modal.remove();
                    });
                });
            });
        }

        // Function to show loading overlay
        function showLoading() {
            document.querySelector('.loading-overlay').style.display = 'flex';
        }

        // Function to hide loading overlay
        function hideLoading() {
            document.querySelector('.loading-overlay').style.display = 'none';
        }

        // Function to show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
            toast.style.display = 'block';
            
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        // Function to edit row
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

        // Function to approve event
        function approveEvent(eventId) {
            if (confirm("Are you sure you want to approve this event?")) {
                showLoading();
                fetch("approve_event.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: eventId, action: 'approve' }),
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status === "success") {
                        showToast("Event approved successfully!");
                        location.reload();
                    } else {
                        showToast("Error approving event", "error");
                    }
                })
                .catch(error => {
                    showToast("Error: " + error.message, "error");
                })
                .finally(() => {
                    hideLoading();
                });
            }
        }

        // Function to reject event
        function rejectEvent(eventId) {
            if (confirm("Are you sure you want to reject this event?")) {
                showLoading();
                fetch("approve_event.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: eventId, action: 'reject' }),
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status === "success") {
                        showToast("Event rejected successfully!");
                        location.reload();
                    } else {
                        showToast("Error rejecting event", "error");
                    }
                })
                .catch(error => {
                    showToast("Error: " + error.message, "error");
                })
                .finally(() => {
                    hideLoading();
                });
            }
        }

        // Function to save row
        function saveRow(btn, type) {
            const row = btn.parentElement.parentElement;
            const data = [...row.cells].slice(1, -1).map(cell => cell.innerText);
            const id = row.cells[0].innerText;

            const updateData = type === "user"
                ? { firstName: data[0], lastName: data[1], email: data[2] }
                : type === "event"
                    ? { name: data[0], description: data[1] }
                    : { title: data[0], question: data[1] };

            showLoading();
            fetch("edit.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ type, id, data: updateData }),
            })
            .then(response => response.json())
            .then(response => {
                if (response.status === "success") {
                    showToast("Data updated successfully!");

                    [...row.cells].forEach((cell, index) => {
                        if (index > 0 && index < row.cells.length - 1) {
                            cell.contentEditable = "false";
                            cell.style.border = "none";
                            cell.style.backgroundColor = "transparent";
                        }
                    });

                    toggleButtons(btn, false);
                } else {
                    showToast("Error updating data", "error");
                }
            })
            .catch(error => {
                showToast("Error: " + error.message, "error");
            })
            .finally(() => {
                hideLoading();
            });
        }

        // Function to confirm and handle deletion
        function confirmDelete(id, type) {
            if (confirm("Are you sure you want to delete this record?")) {
                showLoading();
                fetch("delete.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ type, id }),
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status === "success") {
                        showToast("Record deleted successfully!");
                        location.reload();
                    } else {
                        showToast("Error deleting record", "error");
                    }
                })
                .catch(error => {
                    showToast("Error: " + error.message, "error");
                })
                .finally(() => {
                    hideLoading();
                });
            }
        }

        // Function to cancel edit
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
            showToast("Edit cancelled");
        }

        // Function to toggle button visibility
        function toggleButtons(btn, isEditing) {
            const buttons = btn.parentElement.children;
            buttons[0].style.display = isEditing ? "none" : "inline";
            buttons[1].style.display = isEditing ? "inline" : "none";
            buttons[2].style.display = isEditing ? "inline" : "none";
        }
    </script>
</body>

</html>