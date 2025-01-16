<?php
include "../controllers/contact.php";
include_once '../components/header.php';
?>

</head>

<body>
    <div class="contact-container">
        <h1>Contact Us</h1>

        <?php if (!empty($successMessage)): ?>
            <div class="message success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php elseif (!empty($errorMessage)): ?>
            <div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <div class="contact-info">
            <p>Phone: +33 6 25 45 54 66</p>
            <p>E-mail: <a href="mailto:contact-us@eventspace.com">contact-us@eventspace.com</a></p>
            <p>Location: Rue de Vanves, 92130 Issy-Les-Moulineaux</p>
        </div>

        <form action="" method="post" class="form-container">
            <!-- Left column -->
            <div class="form-column">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
            </div>
            <!-- Right column -->
            <div class="form-column">
                <div class="form-group">
                    <textarea name="message" placeholder="Write your message here" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Send Message</button>
                </div>
            </div>
        </form>
    </div>
    <?php include_once '../components/footer.php'; ?>
</body>

</html>