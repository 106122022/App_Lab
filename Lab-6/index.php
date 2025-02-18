<?php
session_start();
include 'db.php';

// Get the number of users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$row_users = $result_users->fetch_assoc();
$total_users = $row_users['total_users'];

// Get the number of public files
$sql_public = "SELECT COUNT(*) AS total_public_files FROM files WHERE file_type = 'public'";
$result_public = $conn->query($sql_public);
$row_public = $result_public->fetch_assoc();
$total_public_files = $row_public['total_public_files'];

// Get the number of private files
$sql_private = "SELECT COUNT(*) AS total_private_files FROM files WHERE file_type = 'private'";
$result_private = $conn->query($sql_private);
$row_private = $result_private->fetch_assoc();
$total_private_files = $row_private['total_private_files'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");  // Reload the page to show logged-in state
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
    <title>File Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Welcome to the File Management System</h1>

    <div class="stats">
        <h2>Total Number of Users: <?php echo $total_users; ?></h2>
        <h2>Total Public Files: <?php echo $total_public_files; ?></h2>
        <h2>Total Private Files: <?php echo $total_private_files; ?></h2>
    </div>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- Login Form -->
        <div class="form-container">
            <h3>Login</h3>
            <form action="index.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <?php if (isset($login_error)): ?>
                <p style="color: red;"><?php echo $login_error; ?></p>
            <?php endif; ?>
            <a href="register.php">New User? Register Here</a>
        </div>
    <?php else: ?>
        <!-- Logged-in User Dashboard -->
        <div class="form-container">
            <h3>Welcome, <?php echo $_SESSION['username']; ?>!</h3>
            <p>You are logged in.</p>
            <a href="dashboard.php">Go to Dashboard</a>
            <a href="upload.php">Upload a New File</a>
            <a href="logout.php">Logout</a>
        </div>
    <?php endif; ?>

</body>
</html>
