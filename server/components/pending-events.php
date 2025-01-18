<?php
// components/pending-events.php
?>
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
            <td><?php echo htmlspecialchars($event['id']); ?></td>
            <td><?php echo htmlspecialchars($event['name']); ?></td>
            <td><?php echo htmlspecialchars($event['description']); ?></td>
            <td><img src="<?php echo htmlspecialchars($event['coverPhoto']); ?>" alt="Event Cover" class="event-image"></td>
            <td>
                <button class="approve-btn" onclick="approveEvent('<?php echo htmlspecialchars($event['id']); ?>')">Approve</button>
                <button class="reject-btn" onclick="rejectEvent('<?php echo htmlspecialchars($event['id']); ?>')">Reject</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>