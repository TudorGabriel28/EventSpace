<?php
// components/forums.php
?>
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
            <td><?php echo htmlspecialchars($forum['id']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($forum['title']); ?></td>
            <td contenteditable="false"><?php echo htmlspecialchars($forum['question']); ?></td>
            <td><?php echo htmlspecialchars($forum['idUser']); ?></td>
            <td>
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="save-btn" onclick="saveRow(this, 'forum')">Save</button>
                <button class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                <button class="delete-btn" onclick="confirmDelete('<?php echo htmlspecialchars($forum['id']); ?>', 'forum')">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>