<?php
// Direct database update for admin password

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tamu_pengujung_db';
$port = 3307;

try {
    // Create connection using mysqli
    $conn = new mysqli($host, $username, $password, $database, $port);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // New password hash
    $newPasswordHash = '$2y$10$EljBRFuOaaPt/vvsphkrTOfIFHKH.zmaR9GsWFGSmGYNmmaE.rZqC';
    
    // Escape for safety
    $newPasswordHash = $conn->real_escape_string($newPasswordHash);
    
    // SQL Query
    $sql = "UPDATE admin SET password = '$newPasswordHash' WHERE username = 'admin'";
    
    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "✓ Password admin berhasil diupdate!\n";
        echo "Username: admin\n";
        echo "Password: adminperpusdajateng\n";
    } else {
        echo "✗ Gagal update password: " . $conn->error . "\n";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
