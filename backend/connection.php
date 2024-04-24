<?php
// Konfigurasi database
$host = "localhost"; // Host database
$db   = "sait_db_uts"; // Nama database
$user = "root"; // Username database
$pass = ""; // Password database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi script
}