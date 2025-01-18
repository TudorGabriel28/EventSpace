<?php
// components/approved-events.php
?>
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
            <td><?php echo htmlspecialchars($event['id']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($event['name']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($event['description']); ?></td>
            <td>
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="save-btn" onclick="saveRow(this, 'event')">Save</button>
                <button class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                <button class="delete-btn" onclick="confirmDelete('<?php echo htmlspecialchars($event['id']); ?>', 'event')">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
