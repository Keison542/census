<?php
session_start();
// Only allow admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'png_census');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'enumerator')");
    $stmt->bind_param("ss", $username, $hashed);
    if ($stmt->execute()) {
        echo "Enumerator registered! <a href='register_enumerator.php'>Back</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form action="" method="POST" class="p-4">
    <h2>Register Enumerator</h2>
    <input type="text" name="username" placeholder="Enumerator Username" class="form-control mb-2" required>
    <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
    <button type="submit" class="btn btn-primary">Register</button>
</form>
