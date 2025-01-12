<?php 
    $stylesheet = "about-us.css";
?>
<body>

    <?php include_once '../components/header.php'; ?>

    <main class="grid-container">
        <section class="title">
            <img class="banner" src="../assets/aboutus-banner.jpg" alt="About Us Banner">
        </section>
        <section class="who-we-are">
            <div class="who-we-are-text">
                <h2 class="text-xl">Who We Are?</h2>
                <p class="text-md">At EventSpace, we are a dynamic team of five recent graduates from ISEP, driven by a shared passion for innovation and connecting people. As young engineers, we aim to redefine how events are discovered and managed. Born from a vision to simplify and enhance event experiences, our start-up thrives on creativity, collaboration, and the desire to create seamless solutions for event-goers and organizers alike.</p>
            </div>
            <div class="who-we-are-image">
                <img src="../assets/WhoAreWe.jpg" alt="Who We Are Image">
            </div>
        </section>
        <section class="what-we-do">
            <div class="what-we-do-text">
                <h2 class="text-xl">What We Do?</h2>
                <p class="text-md">EventSpace is your all-in-one platform for discovering, attending, and hosting events. We make it easy for users to explore diverse activities tailored to their interests and hobbies, from vibrant music festivals to professional conferences and everything in between. With intuitive tools, our platform ensures that you can find the perfect event and secure your spot in no time.</p>
            </div>
            <div class="what-we-do-image">
                <img src="../assets/WhatWeDo.jpg" alt="What We Do Image">
            </div>
        </section>
    </main>
    <?php include '../components/footer.php'; ?>
</body>
</html>