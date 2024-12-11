<?php
// Include database connection
include '../config.php';
include '../db_connection.php';

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - Eventspace</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* FAQ banner styling */
        .faq-banner {
            text-align: center;
            background: linear-gradient(120deg, #222, #444);
            color: white;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        .faq-banner h1 {
            font-size: 2.5em;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .faq-banner::after {
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

        /* FAQ container styling */
        .faq-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Individual FAQ styling */
        .faq-item {
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 8px;
            transition: transform 0.3s, background-color 0.3s;
            cursor: pointer;
            background: #f9f9f9;
            position: relative;
        }

        .faq-item h3 {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }

        .faq-item p {
            margin: 10px 0 0;
            color: #666;
            line-height: 1.6;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }

        .faq-item.active p {
            max-height: 200px;
            opacity: 1;
        }

        .faq-item:hover {
            background-color: #ff8800;
            color: white;
            transform: scale(1.02);
        }

        .faq-item:hover h3,
        .faq-item:hover p {
            color: white;
        }

        .faq-item::after {
            content: '+';
            font-size: 1.2em;
            position: absolute;
            right: 20px;
            top: 20px;
            color: #666;
            transition: transform 0.3s, color 0.3s;
        }

        .faq-item.active::after {
            content: '-';
            color: white;
            transform: rotate(180deg);
        }
    </style>
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
</head>
<body>
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
</body>
</html>
