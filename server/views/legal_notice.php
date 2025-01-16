<?php
include '../controllers/legal_notice.php';
include_once '../components/header.php';
?>

<main>
    <div class="legal-container">
        <h1 class="text-center">Legal Notice</h1>

        <section class="legal-notice">
            <?php foreach ($legal_notices as $notice): ?>
                <div class="notice">
                    <h3><?= htmlspecialchars($notice['title']); ?></h3>
                    <p><?= nl2br(htmlspecialchars($notice['content'])); ?></p>
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
