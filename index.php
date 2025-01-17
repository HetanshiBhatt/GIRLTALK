<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIRL TALK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Pacifico&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="logo (2).png" alt="Girl Talk Logo">
            </div>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="today.php">TODAY</a></li>
                <li><a href="secretchat.php">SECRET CHAT</a></li>
                <li><a href="messages.php">MESSAGES</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a href="login.php">LOGIN</a></li>
                    <li><a href="signup.php">SIGNUP</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Girl Talk</h1>
            <p>Your health and hygiene platform</p>
        </div>
    </section>

    <!-- <section class="a">
        <img src="f.png" class="clickable-button" alt="Clickable Button">
    </section> -->

    <section class="a">
    <img src="f.png" class="clickable-button" alt="Clickable Button">
</section>

<style>
    .enlarge {
        transform: scale(1.3); /* Adjust the scale as needed */
        transition: transform 0.9s ease; /* Smooth transition */
    }
</style>


    <script>
        // Array of background images for the hero section
        const heroImages = [
            'b.jpg',
            'h.jpg',
            'k.jpg',
            'd.jpg',
            'e.jpeg',
            'a.avif',
        ];

        let currentIndex = 0;

        // Function to change the background image
        function changeHeroBackground() {
            const heroSection = document.querySelector('.hero');
            heroSection.style.backgroundImage = `url(${heroImages[currentIndex]})`;
            currentIndex = (currentIndex + 1) % heroImages.length;  // Cycle through the images
        }

        // Change background every 3 seconds
        setInterval(changeHeroBackground, 3000);

        // Initial call to set the first background
        changeHeroBackground();

        // Click to enlarge functionality for the image
        const clickableImage = document.querySelector('.clickable-button');
        clickableImage.addEventListener('click', () => {
            clickableImage.classList.toggle('enlarge');

            setTimeout(() => {
        window.location.href = 'today.php'; // Redirect after a brief delay
    }, 300);
        });
    </script>

</body>

</html>
