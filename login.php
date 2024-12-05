<?php
session_start();
include('db.php'); // Pastikan file db.php berisi koneksi database yang benar

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set sesi pengguna
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            
            // Redirect ke dashboard.php setelah login berhasil
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "User tidak ditemukan!";
    }

    // Tutup statement dan koneksi untuk keamanan
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit">Login</button>
            <p>Belum punya akun?</p>
            <a href="register.php">
                <button type="button" class="signup-btn">Sign Up</button>
            </a>
        </form>
    </div>
</body>
</html>