<?php

include '../../core/app.php';
// apiHeaders();

use Mindtrack\Lib\FileManager;

try {

    $fileManager = new FileManager();
    $reference_model = $_SERVER['HTTP_X_REFERENCE_MODEL'] ?? null;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            echo $fileManager->storeWhereTemporary($_FILES['file']);
            break;

        case 'GET':
            $foldername = $_GET['folder'] ?? null;
            $file = $fileManager->loadWherePermanent($foldername, $reference_model);
            if (file_exists($file['filepath'])) {
                header('Access-Control-Expose-Headers: Content-Disposition'); // Expose Content-Disposition for CORS if needed
                header('Content-Type: ' . $file['mimetype']);
                header('Content-Length: ' . $file['filesize']);
                header('Content-Disposition: inline; filename="' . $file['filename'] . '"');
                readfile($file['filepath']);
            }
            break;

        case 'DELETE':
            $foldername = file_get_contents('php://input');
            // error_log("foldername: " . $foldername);
            $fileManager->deleteWhereTemporary($foldername);
            $fileManager->deleteWherePermanent($foldername, $reference_model);
            break;
    }

} catch (Exception $e) {
    error_log($e->getMessage());
}

exit;