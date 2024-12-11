<?php
session_start();
include 'db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check if the user exists in the database
    $checkUserQuery = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");  // Redirect to home page after successful login
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Username does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Girl Talk</title>
    <link rel="stylesheet" href="form-styles.css"> <!-- Link to form stylesheet -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>


    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</body>
</html>
