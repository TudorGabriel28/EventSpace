<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventspace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/620a552ea1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/<?php echo $stylesheet ?? 'common.css'; ?>">
    <?php if (!empty($script)): ?>
        <script src="../scripts/<?php echo htmlspecialchars($script); ?>" defer></script>
    <?php endif; ?>
</head>

<body>
    <?php include_once '../components/navbar.php'; ?>