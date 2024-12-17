<?php
include '../config.php';
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $email, $message);

    if ($stmt->execute()) {
        $successMessage = "Thank you! Your message has been sent successfully.";
    } else {
        $errorMessage = "Oops! Something went wrong. Please try again.";
    }

    $stmt->close();
}
?>

<?php include_once '../components/header.php'; ?>
<style>
    /* Global Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .contact-container {
        background: white;
        padding: 30px;
        max-width: 900px;
        margin: 50px auto;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-container h1 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
        color: black; /* Changed to black */
    }

    .contact-info {
        text-align: center;
        margin-bottom: 30px;
        font-size: 1.1em;
    }

    .contact-info p {
        margin: 5px 0;
    }

    .contact-info a {
        color: #007bff;
        text-decoration: none;
    }

    /* Form container divided into two columns using flexbox */
    .form-container {
        display: flex;
        flex-wrap: wrap; /* Ensure columns wrap on smaller screens */
        gap: 20px;
    }

    .form-column {
        flex: 1;
        min-width: 280px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group textarea {
        height: 150px;
        resize: none;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f8f8f8;
        color: #333;
        font-size: 1em;
        box-sizing: border-box;
    }

    .form-group button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-group button:hover {
        background-color: #0056b3;
    }

    .message {
        text-align: center;
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 4px;
        font-size: 1.1em;
    }

    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
</head>
<body>
    <div class="contact-container">
        <h1>Contact Us</h1>

        <?php if (!empty($successMessage)): ?>
            <div class="message success"><?php echo $successMessage; ?></div>
        <?php elseif (!empty($errorMessage)): ?>
            <div class="message error"><?php echo $errorMessage; ?></div>
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
                    <button type="submit">Send Message</button> <!-- Moved below message box -->
                </div>
            </div>
        </form>
    </div>
<?php include_once '../components/footer.php'; ?>
</body>
</html>
