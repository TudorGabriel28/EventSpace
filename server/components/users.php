<?php
// components/users.php
?>
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
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($user['firstName']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($user['lastName']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="save-btn" onclick="saveRow(this, 'user')">Save</button>
                <button class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                <button class="delete-btn" onclick="confirmDelete('<?php echo htmlspecialchars($user['id']); ?>', 'user')">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
