<?php
include "../controllers/terms.php";
include_once '../components/header.php';
?>

<main>
    <!-- Terms Banner -->
    <div class="terms-banner">
        <h1>Terms and Conditions</h1>
    </div>

    <!-- Terms Content -->
    <div class="terms-container">
        <?php if (!empty($terms)): ?>
            <?php foreach ($terms as $term): ?>
                <div class="term">
                    <h2><?= htmlspecialchars($term['title']); ?></h2>
                    <p><?= nl2br(htmlspecialchars($term['content'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No terms and conditions available at the moment.</p>
        <?php endif; ?>
    </div>

    <script>
        // Add interactivity to terms (toggle visibility of content)
        document.addEventListener('DOMContentLoaded', function () {
            const terms = document.querySelectorAll('.term');
            terms.forEach(term => {
                term.addEventListener('click', function () {
                    this.classList.toggle('active');
                });
            });
        });
    </script>
</main>

<?php include_once '../components/footer.php'; ?>