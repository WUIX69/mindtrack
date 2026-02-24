<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Features\Notes\Server\Db\Notes;
use Mindtrack\Features\Notes\Schemas\Notes as NotesSchema;
use Mindtrack\Server\Db\Appointments;

// Initialize global response
global $response;

// Ensure user is authenticated and is an admin
if (!$session->get('uuid') || $session->get('role') !== 'admin') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Handle GET Requests
if ($method === 'GET') {
    $uuid = $_GET['uuid'] ?? null;

    if ($uuid) {
        $noteResult = Notes::singleDetailed($uuid);
        $response = array_merge($response, $noteResult);
    } else {
        $response['message'] = 'Invalid GET parameters. UUID required.';
    }

    echo json_encode($response);
    exit;
}

// Handle POST Requests
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        $input = $_POST;
    }

    $input['uuid'] = $input['uuid'] ?: uuid(); // Generate new UUID if not provided

    $validation = NotesSchema::validate($input);
    if (!$validation['valid']) {
        $response['message'] = 'Validation failed.';
        $response['errors'] = $validation['errors'];
        echo json_encode($response);
        exit;
    }

    $validatedData = $validation['data'];
    $validatedData['doctor_uuid'] = $input['doctor_uuid'] ?? null; // Admin must pass the doctor_uuid for new notes

    if (empty($validatedData['doctor_uuid'])) {
        $response['message'] = 'Provider is required when creating a note.';
        echo json_encode($response);
        exit;
    }

    try {
        $existingNoteResult = Notes::single($validatedData['uuid']);

        if ($existingNoteResult['success'] && !empty($existingNoteResult['data'])) {
            $existingNote = $existingNoteResult['data'];

            // Admin can edit anything. We pass $force = true to bypass the signed restriction.
            $result = Notes::update($existingNote['uuid'], $validatedData, true);
            $result['uuid'] = $existingNote['uuid'];
            $response = array_merge($response, $result);
        } else {
            // Insert new note
            $result = Notes::store($validatedData);

            if ($result['success']) {
                Appointments::updateStatus($validatedData['appointment_uuid'], 'completed');
            }

            $response = array_merge($response, $result);
        }

    } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
}

// Handle DELETE Requests
if ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true) ?? $_GET;
    $uuid = $input['uuid'] ?? null;

    if (!$uuid) {
        $response['message'] = 'Note UUID is required for deletion.';
        echo json_encode($response);
        exit;
    }

    try {
        $result = Notes::delete($uuid);
        $response = array_merge($response, $result);
    } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
}

$response['message'] = 'Invalid request method.';
echo json_encode($response);
exit;
