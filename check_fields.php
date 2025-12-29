#!/usr/bin/env php
<?php
// Quick database check script
require 'vendor/autoload.php';

// Initialize database
$db = \Config\Database::connect();

echo "=== Checking Guest Book Form Fields ===\n\n";

// Get all guest book fields
$fields = $db->table('form_fields')
    ->where('form_type', 'guest_book')
    ->orderBy('sort_order', 'ASC')
    ->get()
    ->getResultArray();

echo "Total fields: " . count($fields) . "\n\n";

foreach ($fields as $field) {
    echo "ID: {$field['id']} | Sort: {$field['sort_order']} | Name: {$field['field_name']} | Label: {$field['field_label']}\n";
}

// Check for duplicates
echo "\n=== Checking for Duplicate Field Names ===\n";
$duplicates = $db->table('form_fields')
    ->select('field_name, COUNT(*) as count')
    ->where('form_type', 'guest_book')
    ->groupBy('field_name')
    ->having('count >', 1)
    ->get()
    ->getResultArray();

if (empty($duplicates)) {
    echo "No duplicates found!\n";
} else {
    echo "Found duplicates:\n";
    foreach ($duplicates as $dup) {
        echo "  - {$dup['field_name']}: {$dup['count']} occurrences\n";
    }
}
?>
