<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");  // Redirect to index if not logged in
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_POST['file_type']; // 'public', 'private', 'complete_private'
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);
    move_uploaded_file($file_tmp, $target_file);

    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO files (file_name, file_path, file_type, uploaded_by) 
            VALUES ('$file_name', '$target_file', '$file_type', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        echo "File uploaded successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h1>Upload a New File</h1>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <select name="file_type" required>
        <option value="public">Public</option>
        <option value="complete_private">Complete Private</option>
    </select>
    <button type="submit">Upload File</button>
</form>
