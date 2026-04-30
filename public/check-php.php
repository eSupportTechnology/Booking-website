<?php
header('Content-Type: text/plain');

echo "=== PHP Upload Configuration ===\n\n";

$tempDir = ini_get('upload_tmp_dir');
$sysTempDir = sys_get_temp_dir();

echo "upload_tmp_dir: " . ($tempDir ?: '(not set)') . "\n";
echo "sys_get_temp_dir: " . $sysTempDir . "\n";
echo "Temp dir exists: " . (is_dir($sysTempDir) ? 'YES' : 'NO') . "\n";
echo "Temp dir writable: " . (is_writable($sysTempDir) ? 'YES' : 'NO') . "\n\n";

// Try to create a temp file
$testFile = @tempnam($sysTempDir, 'test_');
if ($testFile) {
    echo "Can create temp files: YES\n";
    unlink($testFile);
} else {
    echo "Can create temp files: NO - THIS IS THE PROBLEM!\n";
}

echo "\n=== Solution ===\n";
echo "Add this to your php.ini:\n";
echo "upload_tmp_dir = \"C:/xampp/tmp\"\n";
echo "OR\n";
echo "upload_tmp_dir = \"" . str_replace('\\', '/', dirname(__DIR__)) . "/storage/tmp\"\n";
