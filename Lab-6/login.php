<?php
session_start();
include 'db.php';

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password match any user in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Set session variables for logged-in user
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];

        // Redirect to index.php (main page)
        header("Location: index.php");
        exit();
    } else {
        $login_error = "Invalid credentials!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - File Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Login to the File Management System</h1>

    <div class="form-container">
        <h3>Login</h3>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($login_error)): ?>
            <p style="color: red;"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <a href="register.php">New User? Register Here</a>
    </div>

</body>
</html>
