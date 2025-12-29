<?php
// Koneksi langsung ke database MySQL
$mysqli = new mysqli('localhost', 'root', '', 'pengunjung-perpustakaan');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$newHash = '$2y$10$EljBRFuOaaPt/vvsphkrTOfIFHKH.zmaR9GsWFGSmGYNmmaE.rZqC';

// Update password
$sql = "UPDATE admins SET password = ? WHERE username = 'admin'";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $newHash);

if ($stmt->execute()) {
    echo "SUCCESS: Password admin berhasil diupdate ke adminperpusdajateng" . PHP_EOL;
    
    // Verify
    $result = $mysqli->query("SELECT username, password FROM admins WHERE username = 'admin'");
    $row = $result->fetch_assoc();
    echo "Username: " . $row['username'] . PHP_EOL;
    echo "Password Hash: " . $row['password'] . PHP_EOL;
} else {
    echo "ERROR: " . $stmt->error . PHP_EOL;
}

$stmt->close();
$mysqli->close();
?>
