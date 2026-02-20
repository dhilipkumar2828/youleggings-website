<?php
echo "Checking System Requirements...\n";
echo "-----------------------------\n";

// Check fileinfo
if (extension_loaded('fileinfo')) {
    echo "[PASS] fileinfo extension is enabled.\n";
} else {
    echo "[FAIL] fileinfo extension is DISABLED.\n";
    echo "       You MUST enable 'extension=fileinfo' in your php.ini file.\n";
    echo "       Loaded php.ini: " . php_ini_loaded_file() . "\n";
}

// Check config
$lfmDisk = config('lfm.disk');
if ($lfmDisk === 'public') {
    echo "[PASS] lfm.disk is set to 'public'.\n";
} else {
    echo "[FAIL] lfm.disk is set to '$lfmDisk'.\n";
    echo "       It MUST be set to 'public'.\n";
}

echo "-----------------------------\n";
