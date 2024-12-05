<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mobil_db';

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>