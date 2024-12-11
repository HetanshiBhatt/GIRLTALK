<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Chat - Girl Talk</title>

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
        <h1>Secret Chat</h1>
        <p>Ask your questions about health, periods, hygiene, and more.</p>
    </header>

    <section class="chat-container">
        <div id="chat-box">
            <!-- Chat messages will appear here -->
        </div>

        <div class="input-area">
            <form method="post" onsubmit="processUserInput(); return false;">
                <input type="text" id="user-input" name="user-input" placeholder="Type your question here..." autocomplete="off">
                <button type="submit">Send</button>
            </form>
        </div>
    </section>

    <script>
        // Predefined responses
        const responses = {
            "pcos symptoms": "Symptoms of PCOS may include irregular periods, excessive hair growth, acne, weight gain, and sometimes fertility issues.",
            "period pain": "Period pain can often be managed with a warm compress, light exercise, and staying hydrated. Severe pain might need medical attention.",
            "menstrual hygiene": "Menstrual hygiene involves changing pads or tampons regularly and washing with mild soap. Avoid scented products that might cause irritation.",
            "safe sex": "Safe sex includes using protection, regular health check-ups, and open communication with partners about health.",
            "missed period": "Missed periods can happen for many reasons, including stress, weight changes, and hormonal imbalances. If you're concerned, consider consulting a healthcare provider.",
            "healthy period": "A healthy menstrual cycle typically lasts between 21-35 days. Staying hydrated, eating a balanced diet, and reducing stress can help maintain a healthy cycle.",
            "period tracking": "Tracking your period helps you understand your cycle better. Apps or a simple calendar can be useful for recording symptoms, moods, and dates.",
        };

        const chatBox = document.getElementById('chat-box');

        // Function to display messages in the chatbox
        function displayMessage(content, sender) {
            const message = document.createElement('div');
            message.classList.add('message', sender);
            message.innerText = content;
            chatBox.appendChild(message);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Process user input and generate a response
        function processUserInput() {
            const userInput = document.getElementById('user-input').value.toLowerCase();
            displayMessage(userInput, 'user');
            document.getElementById('user-input').value = ''; // Clear input box

            let foundResponse = false;
            for (let key in responses) {
                if (userInput.includes(key)) {
                    displayMessage(responses[key], 'bot');
                    foundResponse = true;
                    break;
                }
            }
            if (!foundResponse) {
                displayMessage("I'm here to help, but you may want to consult a healthcare provider for personalized advice.", 'bot');
            }
        }
    </script>
</body>
</html>
