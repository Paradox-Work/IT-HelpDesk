<?php

// fix-filament-structure.php
$oldPath = __DIR__ . '/app/Filament/Resources/Tickets/Resources/TicketReplies';
$newPath = __DIR__ . '/app/Filament/Resources/TicketReplies';

if (!is_dir($oldPath)) {
    die("Old TicketReplies folder not found.\n");
}

// Step 1: Create new TicketReplies folder structure
$folders = ['Pages', 'Schemas', 'Tables'];
foreach ($folders as $folder) {
    if (!is_dir("$newPath/$folder")) {
        mkdir("$newPath/$folder", 0777, true);
    }
}

// Step 2: Move files
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($oldPath, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);

foreach ($iterator as $fileinfo) {
    $oldFile = $fileinfo->getRealPath();
    $relativePath = str_replace($oldPath . DIRECTORY_SEPARATOR, '', $oldFile);
    $newFile = $newPath . DIRECTORY_SEPARATOR . $relativePath;

    if ($fileinfo->isDir()) {
        if (!is_dir($newFile)) mkdir($newFile);
        rmdir($oldFile);
    } else {
        rename($oldFile, $newFile);

        // Step 3: Fix namespaces in PHP files
        $contents = file_get_contents($newFile);
        $contents = preg_replace(
            '#namespace\s+App\\\\Filament\\\\Resources\\\\Tickets\\\\Resources\\\\TicketReplies#',
            'namespace App\\Filament\\Resources\\TicketReplies',
            $contents
        );
        file_put_contents($newFile, $contents);
    }
}

// Step 4: Remove old empty folders
@rmdir(__DIR__ . '/app/Filament/Resources/Tickets/Resources');

echo "TicketReplies resource moved and namespaces fixed successfully.\n";
