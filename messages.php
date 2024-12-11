<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Girl Talk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles2.css">
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
    
    <header>
        <h1>Community Messages</h1>
        <p>Share your experiences and stories anonymously.</p>
    </header>

    <section class="messages-container">
        <div id="messages-list">
            <?php
            // Display saved messages
            $file = 'messages.txt';
            if (file_exists($file)) {
                $messages = file($file, FILE_IGNORE_NEW_LINES);
                foreach (array_reverse($messages) as $msg) { // Display newest messages at the top
                    echo "<div class='user-message'>" . htmlspecialchars($msg) . "</div>";
                }
            }
            ?>
        </div>

        <div class="input-area">
            <form action="" method="post">
                <textarea name="user_message" id="user-message" placeholder="Share your story..." rows="4"></textarea>
                <button type="submit">Post</button>
            </form>
        </div>
    </section>

    <?php
    // Save the message when submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty(trim($_POST['user_message']))) {
        $userMessage = trim($_POST['user_message']);
        file_put_contents($file, $userMessage . PHP_EOL, FILE_APPEND | LOCK_EX);
        // Refresh the page to show the new message
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }
    ?>
</body>
</html>
