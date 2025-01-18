<?php
include "../controllers/faq.php";
include_once '../components/header.php';
?>
<main>
    <div class="faq-banner">
        <h1>Frequently Asked Questions</h1>
    </div>

    <div class="faq-container">
        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <h3><?= htmlspecialchars($faq['question']); ?></h3>
                    <p><?= htmlspecialchars($faq['answer']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No FAQs available at the moment.</p>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                item.addEventListener('click', function () {
                    this.classList.toggle('active');
                });
            });
        });
    </script>
</main>
<?php include_once '../components/footer.php'; ?>
</body>

</html>