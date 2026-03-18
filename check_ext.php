<?php
$required = ['gd', 'zip', 'bcmath', 'mbstring', 'xml', 'curl', 'openssl', 'pdo_mysql'];
foreach ($required as $ext) {
    if (!extension_loaded($ext)) {
        echo "Missing: ext-$ext \n";
    } else {
        echo "Loaded: ext-$ext \n";
    }
}
echo "PHP Version: " . PHP_VERSION . "\n";
