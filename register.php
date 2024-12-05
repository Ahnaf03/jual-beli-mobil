<?php
session_start();
include('db.php');

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Periksa apakah password dan konfirmasi password cocok
    if ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password sebelum menyimpan ke database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php"); // Redirect ke halaman login
            exit();
        } else {
            $error_message = "Username sudah digunakan atau terjadi kesalahan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register"
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="register.php">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required><br><br>
            <label for="confirm_password">Konfirmasi Password:</label><br>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>
            <button type="submit">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>