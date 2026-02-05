<?php

namespace VetSync\Services;

use VetSync\Models\Attachments;

class FileManager
{
    private $uploadDirectory;
    private $response;

    public function __construct()
    {
        global $response;
        $this->response = $response;

        global $config;
        $this->uploadDirectory = $config['root_path'] . '/src/uploads/';
    }

    /**
     * Instant upload a file to the specified destination.
     *
     * @param array $file The uploaded file array (e.g., from $_FILES)
     * @param string $reference_model The destination folder name
     * @param string $reference_uuid The reference UUID
     * @param array $args Additional arguments (required)
     * @return array Returns the response on success, empty array on failure
     */
    public function storeWhereInstant($file, $reference_model, $reference_uuid, $args = [])
    {

        // Check for upload errors
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            error_log('STORE INSTANT: Upload error: ' . $file['error']);
            return $this->response;
        }

        // Set base destination path
        $basePath = $this->uploadDirectory . $reference_model;

        // Ensure base destination directory exists
        if (!is_dir($basePath) && !mkdir($basePath, 0777, true)) {
            error_log('STORE INSTANT: Failed to create base directory: ' . $basePath);
            return $this->response;
        }

        // Create a unique UUID for the folder name
        $folderName = uuid();

        // Create folder inside the destination
        $folderPath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;
        if (!mkdir($folderPath, 0777, true)) {
            error_log('STORE INSTANT: Failed to create folder: ' . $folderPath);
            return $this->response;
        }

        // Keep original filename
        $filename = $file['name'];
        $targetPath = $folderPath . DIRECTORY_SEPARATOR . $filename;

        // Move the uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $this->response;
        }

        // Delete Existing file first
        $oldFile = Attachments::single($reference_uuid);
        if ($oldFile['success'] && !empty($oldFile['data'])) {
            $this->deleteWherePermanent($oldFile['data']['folder'], $reference_model);
            Attachments::deleteWhereReference($reference_model, $reference_uuid);
        }

        // Store new file
        $this->response = Attachments::store([
            'reference_model' => $reference_model,
            'reference_uuid' => $reference_uuid,
            'folder' => $folderName,
            'filename' => $filename,
        ]);

        $this->response['data']['folder'] = $folderName;
        return $this->response;
    }

    /**
     * Upload a file to temporary folder.
     *
     * @param array|string $file The uploaded file array (e.g., from $_FILES)
     * @param array $args Additional arguments (optional)
     * @return string Returns the folder name on success for filepond, empty string on failure
     */
    public function storeWhereTemporary($file, $args = [])
    {
        // Set base destination path
        $basePath = $this->uploadDirectory . 'tmp';

        // Ensure base destination directory exists
        if (!is_dir($basePath) && !mkdir($basePath, 0777, true)) {
            error_log('STORE TEMPORARY: Failed to create base directory: ' . $basePath);
            return '';
        }

        // Create a unique UUID for the folder name
        $folderName = uuid();

        // Create folder inside the destination
        $folderPath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;
        if (!mkdir($folderPath, 0777, true)) {
            error_log('STORE TEMPORARY: Failed to create folder: ' . $folderPath);
            return '';
        }

        // Keep original filename
        $filename = $file['name'];
        $targetPath = $folderPath . DIRECTORY_SEPARATOR . $filename;

        // Move the uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            error_log('STORE TEMPORARY: Failed to move file: ' . $targetPath);
            return '';
        }

        return $folderName;
    }

    /**
     * Move a file from temporary folder to permanent folder.
     *
     * @param array|string $folderName The foldername (UUID) to move from
     * @param string $reference_model The destination folder name
     * @param string $reference_uuid The reference UUID
     * @param array $args Additional arguments (optional)
     * @return array Returns the $response array
     */
    public function storeWherePermanent($folderName, $reference_model, $reference_uuid, $args = [])
    {

        if (empty($folderName)) {
            error_log('STORE PERMANENT: Folder name not found');
            return $this->response;
        }

        // Clean the folder name
        $folderName = trim($folderName, '"\'{}[]');

        // Set source path (temp folder)
        $tempPath = $this->uploadDirectory . 'tmp';
        $sourceFolderPath = rtrim($tempPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;

        // Check if source folder exists
        if (!is_dir($sourceFolderPath)) {
            error_log('STORE PERMANENT: Source folder not found');
            return $this->response;
        }

        // Get the first file in the source folder (assuming there's just one)
        $files = glob($sourceFolderPath . '/*');
        if (empty($files) || !is_file($files[0])) {
            error_log('STORE PERMANENT: Source file not found');
            return $this->response;
        }

        $sourceFilePath = $files[0];
        $filename = basename($sourceFilePath);

        // Set destination path
        $destPath = $this->uploadDirectory . $reference_model;

        // Ensure destination directory exists
        if (!is_dir($destPath) && !mkdir($destPath, 0777, true)) {
            error_log('STORE PERMANENT: Destination folder does not exist');
            return $this->response;
        }

        // Create destination folder using the same UUID
        $destFolderPath = rtrim($destPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;
        if (!is_dir($destFolderPath) && !mkdir($destFolderPath, 0777, true)) {
            error_log('STORE PERMANENT: Failed to create destination folder');
            return $this->response;
        }

        // Copy file to destination
        $destFilePath = $destFolderPath . DIRECTORY_SEPARATOR . $filename;
        if (!copy($sourceFilePath, $destFilePath)) {
            error_log('STORE PERMANENT: Failed to copy file to destination');
            return $this->response;
        }

        // Remove the source file and folder
        unlink($sourceFilePath);
        rmdir($sourceFolderPath);

        // Store new file
        $this->response = Attachments::store([
            'reference_uuid' => $reference_uuid,
            'reference_model' => $reference_model,
            'folder' => $folderName,
            'filename' => $filename,
        ]);

        error_log("STORE PERMANENT UPLOAD RESULT: " . print_r($this->response, true));
        return $this->response;
    }

    /**
     * Delete a folder/file from temporary folder.
     *
     * @param string $folderName The folder name (UUID) to delete
     * @param array $args Additional arguments (optional)
     * @return bool True if successful, false otherwise
     */
    public function deleteWhereTemporary($folderName, $args = [])
    {
        // Clean the folder name (in case it contains path separators or is JSON)
        $folderName = trim($folderName, '"\'{}[]');

        // Set base destination path
        $basePath = $this->uploadDirectory . 'tmp';
        $folderPath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;

        // Check if folder exists
        if (!is_dir($folderPath)) {
            error_log("DELETE TEMPORARY: Folder not found on temporary folder: " . $folderPath);
            return false;
        }

        // Remove all files inside the folder, then remove the folder itself
        foreach (glob($folderPath . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Remove the folder
        return rmdir($folderPath);
    }

    /**
     * Delete a file/folder from permanent folder.
     *
     * @param string $folderName The foldername (UUID) to delete
     * @param string $reference_model The destination folder name
     * @param array $args Additional arguments (optional)
     * @return bool Returns the $response array or true if successful
     */
    public function deleteWherePermanent($folderName, $reference_model, $args = [])
    {
        // Clean the folder name (in case it contains path separators or is JSON)
        $folderName = trim($folderName, '"\'{}[]');

        // Set base destination path
        $basePath = $this->uploadDirectory . $reference_model;
        $folderPath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;

        // Check if folder exists
        if (!is_dir($folderPath)) {
            error_log("DELETE PERMANENT: Folder not found on $reference_model: " . $folderPath);
            return false;
        }

        // Remove all files inside the folder
        foreach (glob($folderPath . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Remove the folder
        if (!rmdir($folderPath)) {
            error_log("DELETE PERMANENT: Failed to remove folder $folderPath");
            return false;
        }

        // Delete the attachment from the database
        $result = Attachments::deleteWhereFolder($folderName);
        if (!$result['success']) {
            error_log("DELETE PERMANENT: Failed to delete attachment from database");
            return false;
        }

        return true;
    }

    /**
     * Delete all folders/files from permanent folder for a given reference_uuid and reference_model.
     *
     * @param string $reference_uuid The reference UUID
     * @param string $reference_model The destination folder name
     * @param array $args Additional arguments (optional)
     * @return array Returns the $response array or true if successful
     */
    public function deleteWhereReferencePermanent($reference_uuid, $reference_model, $args = [])
    {
        $attachments = Attachments::all($reference_uuid);
        if (!$attachments['success'] || empty($attachments['data'])) {
            error_log("DELETE WHERE REFERENCE PERMANENT: Attachments not found for $reference_uuid");
            return $this->response;
        }

        $basePath = $this->uploadDirectory . $reference_model;
        $allSuccess = true;

        foreach ($attachments['data'] as $attachment) {
            $folder = $attachment['folder'];
            $folderPath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folder;

            if (is_dir($folderPath)) {
                // Remove all files inside the folder
                foreach (glob($folderPath . '/*') as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                // Remove the folder
                if (!rmdir($folderPath)) {
                    $allSuccess = false;
                    error_log("DELETE PERMANENT: Failed to remove folder $folderPath");
                }
            }
        }

        // Delete all attachments from the database for this reference_model and reference_uuid
        $deleteResult = Attachments::deleteWhereReference($reference_uuid, $reference_model);
        if (!$deleteResult['success']) {
            $allSuccess = false;
        }

        if ($allSuccess) {
            $this->response['success'] = true;
            $this->response['message'] = 'All attachments and folders deleted successfully.';
        } else {
            $this->response['message'] = 'Some folders or attachments could not be deleted.';
        }

        error_log("DELETE WHERE REFERENCE PERMANENT RESULT: " . print_r($this->response, true));
        return $this->response;
    }

    /**
     * Load a file from the specified destination.
     *
     * @param string $folderName The folder name (UUID) to load
     * @param string $reference_model The destination folder name
     * @param array $args Additional arguments (optional)
     * @return array|bool File data or false on failure
     */
    public function loadWherePermanent($folderName, $reference_model, $args = [])
    {
        $basePath = $this->uploadDirectory . $reference_model;
        $folderPath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $folderName;

        if (!is_dir($folderPath)) {
            error_log("LOAD: Folder not found on $reference_model: " . $folderPath);
            return false;
        }

        // Get the first file in the folder
        $files = glob($folderPath . '/*');
        if (empty($files) || !is_file($files[0])) {
            error_log("LOAD: File not found on $reference_model: " . $folderPath);
            return false;
        }

        $filePath = $files[0];
        $filename = basename($filePath);
        $fileSize = filesize($filePath);
        $mimeType = mime_content_type($filePath);

        // Return file data
        return [
            'foldername' => $folderName,
            'filename' => $filename,
            'filesize' => $fileSize,
            'mimetype' => $mimeType,
            'filepath' => $filePath
        ];
    }
}