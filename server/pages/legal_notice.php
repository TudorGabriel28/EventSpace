<?php
include '../config.php';
include '../db_connection.php';

$stylesheet = "../styles/legal-notice.css";

$sql = "SELECT title, content FROM legal_notice order by id asc";
$stmt_legal = $conn->prepare($sql);
$stmt_legal->execute();
$result = $stmt_legal->get_result();
while ($row = $result->fetch_assoc()) {
    $legal_notices[] = $row;
}


?>

<?php include_once '../components/header.php'; ?>

<main>
<div class="legal-container">
    <h1 class="text-center">Legal Notice</h1>

    <section class="legal-notice">
        <?php foreach ($legal_notices as $notice): ?>
            <div class="notice">
                <h3><?php echo htmlspecialchars($notice['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($notice['content'])); ?></p>
            </div>
        <?php endforeach; ?>
    </section>


</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
            const notices = document.querySelectorAll('.notice');
            notices.forEach(notice => {
                notice.addEventListener('click', function () {
                    this.classList.toggle('active');
                });
            });
        });
</script>

<?php include_once '../components/footer.php'; ?>