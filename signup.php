<?php
session_start();
include 'db.php';  // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

    // Check if the username already exists
    $checkUserQuery = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose another one.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: login.php");  // Redirect to login page after successful signup
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Girl Talk</title>
    <link rel="stylesheet" href="form-styles.css"> <!-- Link to form stylesheet -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

</head>
<body>

    <div class="form-container">
        <h2>Sign Up</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="signup.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
