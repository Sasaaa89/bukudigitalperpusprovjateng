<?php
// Load environment
require 'vendor/autoload.php';

// Get database config from .env or use defaults
$host = getenv('database.default.hostname') ?: 'localhost';
$database = getenv('database.default.database') ?: 'pengunjung-perpustakaan';
$username = getenv('database.default.username') ?: 'root';
$password = getenv('database.default.password') ?: '';

// Connect to database
try {
    $db = new mysqli($host, $username, $password, $database);
    
    if ($db->connect_error) {
        echo "Error connecting to database: " . $db->connect_error . "\n";
        exit(1);
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Clear existing form_fields if needed
// $db->table('form_fields')->truncate();

// Insert form fields dari seeder
$feedbackFields = [
    [
        'form_type' => 'feedback',
        'field_name' => 'nama_lengkap',
        'field_label' => 'Nama Lengkap',
        'field_type' => 'text',
        'is_required' => 1,
        'field_options' => null,
        'sort_order' => 1,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'feedback',
        'field_name' => 'email',
        'field_label' => 'Email',
        'field_type' => 'email',
        'is_required' => 0,
        'field_options' => null,
        'sort_order' => 2,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'feedback',
        'field_name' => 'rating',
        'field_label' => 'Rating Layanan',
        'field_type' => 'select',
        'is_required' => 1,
        'field_options' => json_encode(['Sangat Baik', 'Baik', 'Cukup', 'Kurang', 'Sangat Kurang']),
        'sort_order' => 3,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
];

$guestBookFields = [
    [
        'form_type' => 'guest_book',
        'field_name' => 'nama_lengkap',
        'field_label' => 'Nama Lengkap',
        'field_type' => 'text',
        'is_required' => 1,
        'field_options' => null,
        'sort_order' => 1,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'guest_book',
        'field_name' => 'asal_instansi',
        'field_label' => 'Asal Instansi',
        'field_type' => 'text',
        'is_required' => 1,
        'field_options' => null,
        'sort_order' => 2,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'guest_book',
        'field_name' => 'keperluan',
        'field_label' => 'Keperluan',
        'field_type' => 'select',
        'is_required' => 1,
        'field_options' => 'keperluan_table',
        'sort_order' => 3,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'guest_book',
        'field_name' => 'nomor_telepon',
        'field_label' => 'Nomor Telepon',
        'field_type' => 'text',
        'is_required' => 0,
        'field_options' => null,
        'sort_order' => 4,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'guest_book',
        'field_name' => 'pesan',
        'field_label' => 'Pesan',
        'field_type' => 'textarea',
        'is_required' => 0,
        'field_options' => null,
        'sort_order' => 5,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'guest_book',
        'field_name' => 'tanggal_kunjungan',
        'field_label' => 'Tanggal Kunjungan',
        'field_type' => 'date',
        'is_required' => 1,
        'field_options' => null,
        'sort_order' => 6,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'form_type' => 'guest_book',
        'field_name' => 'file_kunjungan',
        'field_label' => 'File Kunjungan',
        'field_type' => 'file',
        'is_required' => 0,
        'field_options' => null,
        'sort_order' => 7,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
];

// Check if data already exists
$result = $db->query("SELECT COUNT(*) as count FROM form_fields WHERE form_type = 'guest_book'");
$row = $result->fetch_assoc();
$existingCount = $row['count'];

if ($existingCount == 0) {
    echo "Inserting form fields...\n";
    
    // Insert feedback fields
    foreach ($feedbackFields as $field) {
        $columns = implode(", ", array_keys($field));
        $values = array_values($field);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));
        
        $stmt = $db->prepare("INSERT INTO form_fields ($columns) VALUES ($placeholders)");
        $types = str_repeat("s", count($values));
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $stmt->close();
    }
    
    // Insert guest book fields
    foreach ($guestBookFields as $field) {
        $columns = implode(", ", array_keys($field));
        $values = array_values($field);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));
        
        $stmt = $db->prepare("INSERT INTO form_fields ($columns) VALUES ($placeholders)");
        $types = str_repeat("s", count($values));
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $stmt->close();
    }
    
    echo "Form fields inserted successfully!\n";
} else {
    echo "Form fields already exist. Skipping insert.\n";
    echo "Current guest book fields:\n";
    $result = $db->query("SELECT field_name, field_label FROM form_fields WHERE form_type = 'guest_book'");
    while ($row = $result->fetch_assoc()) {
        echo "  - " . $row['field_name'] . " (" . $row['field_label'] . ")\n";
    }
}

$db->close();
?>
