<?php

// scripts/post-install.php

$filename = __DIR__ . '/../thinkadmin';
$content = "<?php\n\n// This file is created by Composer post-install script.\n";

if (file_put_contents($filename, $content) !== false) {
    echo "File 'thinkadmin' created successfully.\n";
} else {
    echo "Failed to create file 'thinkadmin'.\n";
}
