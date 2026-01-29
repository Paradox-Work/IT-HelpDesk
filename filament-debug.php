<?php

$path = __DIR__ . '/app/Filament';

function listFolder($dir, $prefix = '') {
    if (!is_dir($dir)) {
        echo "$dir is not a directory.\n";
        return;
    }
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
        echo $prefix . $file;
        if (is_dir($fullPath)) {
            echo "/\n";
            listFolder($fullPath, $prefix . '  ');
        } else {
            echo "\n";
        }
    }
}

listFolder($path);
