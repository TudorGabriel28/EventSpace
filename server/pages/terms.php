<?php
include '../config.php';
include '../db_connection.php';

// Fetch T&C content from the database
$terms = [];
try {
    $query = "SELECT title, content FROM terms_conditions ORDER BY created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $terms[] = $row;
    }
} catch (mysqli_sql_exception $e) {
    die("Error fetching Terms and Conditions: " . $e->getMessage());
}
?>

<?php include_once '../components/header.php'; ?>

<style>
    /* General body styling */
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    /* Banner styling with pulse animation */
    .terms-banner {
        text-align: center;
        background: linear-gradient(120deg, #222, #444);
        color: white;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }

    .terms-banner h1 {
        font-size: 2.5em;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .terms-banner::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 136, 0, 0.3);
        clip-path: circle(50% at 50% 50%);
        animation: pulse 5s infinite;
        z-index: 1;
    }

    @keyframes pulse {
        0%, 100% {
            clip-path: circle(30% at 50% 50%);
        }
        50% {
            clip-path: circle(60% at 50% 50%);
        }
    }

    /* Container styling */
    .terms-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Individual term styling with transitions */
    .term {
        margin-bottom: 15px;
        padding: 20px;
        border-radius: 8px;
        transition: transform 0.3s, background-color 0.3s;
        cursor: pointer;
        background: #f9f9f9;
        position: relative;
    }

    .term h2 {
        margin: 0;
        font-size: 1.5em;
        color: #333;
    }

    .term p {
        margin: 10px 0 0;
        color: #666;
        line-height: 1.6;
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.3s ease, opacity 0.3s ease;
    }

    .term.active p {
        max-height: 200px;
        opacity: 1;
    }

    .term:hover {
        background-color: #ff8800;
        color: white;
        transform: scale(1.02);
    }

    .term:hover h2,
    .term:hover p {
        color: white;
    }

    .term::after {
        content: '+';
        font-size: 1.2em;
        position: absolute;
        right: 20px;
        top: 20px;
        color: #666;
        transition: transform 0.3s, color 0.3s;
    }

    .term.active::after {
        content: '-';
        color: white;
        transform: rotate(180deg);
    }
</style>

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
                    <h2><?php echo htmlspecialchars($term['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($term['content'])); ?></p>
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
