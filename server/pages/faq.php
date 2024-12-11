<?php
// Include database connection
include '../config.php';
include '../db_connection.php';

$stylesheet = 'faq.css';

// Fetch FAQs from the database
$faqs = [];
try {
    $query = "SELECT id, question, answer FROM faq";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching FAQs: " . $e->getMessage());
}
?>
<?php include_once '../components/header.php'; ?>
<main>
    <div class="faq-banner">
        <h1>Frequently Asked Questions</h1>
    </div>

    <div class="faq-container">
        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                    <p><?php echo htmlspecialchars($faq['answer']); ?></p>
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