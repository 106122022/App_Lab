<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");  // Redirect to index if not logged in
}

$user_id = $_SESSION['user_id'];
$sql_files = "SELECT * FROM files WHERE uploaded_by = '$user_id'";
$result_files = $conn->query($sql_files);
?>

<h1>Dashboard</h1>
<h3>Welcome, <?php echo $_SESSION['username']; ?>!</h3>
<h3>Your Files:</h3>

<?php while ($row = $result_files->fetch_assoc()): ?>
    <div>
        <p><?php echo $row['file_name']; ?> (<?php echo $row['file_type']; ?>)</p>
    </div>
<?php endwhile; ?>

<a href="upload.php">Upload a New File</a>
<a href="logout.php">Logout</a>
