<?php

require_once dirname(__DIR__, 4) . '/core/app.php';
apiHeaders();

use Mindtrack\Features\Notes\Server\Db\Notes;

use Mindtrack\Features\Notes\Schemas\Notes as NotesSchema;
use Mindtrack\Server\Db\Appointments;

// Initialize global response
global $response;

// Ensure user is authenticated and is a doctor
if (!$session->get('uuid') || $session->get('role') !== 'doctor') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

$doctorUuid = $session->get('uuid') ?? null;
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET Requests
if ($method === 'GET') {
    $action = $_GET['action'] ?? null;
    $appointmentUuid = $_GET['appointment_uuid'] ?? null;

    if ($action === 'list') {
        // Fetch all notes for the logged-in doctor
        $notesResult = Notes::allWhereDoctor($doctorUuid);
        $response = array_merge($response, $notesResult);
    } elseif ($appointmentUuid) {
        // Fetch a specific note and appointment info for an appointment
        $noteResult = Notes::findByAppointment($appointmentUuid);
        $appointment = Appointments::getSingleAppointment($appointmentUuid);

        if (!$appointment || !$appointment['success']) {
            $response['message'] = $appointment['message'] ?? 'Appointment not found.';
            echo json_encode($response);
            exit;
        }

        // Return both existing note (if any) and appointment context
        $response['success'] = true;
        $response['message'] = 'Note and appointment fetched successfully.';
        $response['data'] = [
            'note' => ($noteResult['success'] && !empty($noteResult['data'])) ? $noteResult['data'] : null,
            'appointment' => ($appointment['success'] && !empty($appointment['data'])) ? $appointment['data'] : null
        ];
    } else {
        $response['message'] = 'Invalid GET parameters.';
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

    $action = $input['action'] ?? null;
    $input['uuid'] = $input['uuid'] ?: uuid(); // Generate new UUID if not provided (for new notes only draft or signed)

    $validation = NotesSchema::validate($input);
    if (!$validation['valid']) {
        $response['message'] = 'Validation failed.';
        $response['errors'] = $validation['errors'];
        echo json_encode($response);
        exit;
    }

    $validatedData = $validation['data'];

    try {
        $existingNoteResult = Notes::single($validatedData['uuid']);

        if ($existingNoteResult['success'] && !empty($existingNoteResult['data'])) {
            $existingNote = $existingNoteResult['data'];
            // Update existing
            $result = Notes::update($existingNote['uuid'], $validatedData);
            // Return the UUID so frontend knows it
            if ($result['success']) {
                $result['uuid'] = $existingNote['uuid'];
            }
            $response = array_merge($response, $result);
        } else {
            // Insert new note
            $validatedData['doctor_uuid'] = $doctorUuid;

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

$response['message'] = 'Invalid request method.';
echo json_encode($response);
exit;
