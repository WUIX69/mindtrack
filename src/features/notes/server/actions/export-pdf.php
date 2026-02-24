<?php

require_once dirname(__DIR__, 4) . '/core/app.php';

use Mindtrack\Features\Notes\Server\Db\Notes;
use Dompdf\Dompdf;
use Dompdf\Options;

// Ensure user is authenticated
$validRoles = ['doctor', 'patient'];
if (!$session->get('uuid') || !in_array($session->get('role'), $validRoles)) {
    http_response_code(403);
    die('Unauthorized access.');
}

$userUuid = $session->get('uuid');
$userRole = $session->get('role');

$method = $_SERVER['REQUEST_METHOD'];

// Handle GET Requests
if ($method === 'GET') {
    $uuid = $_GET['uuid'] ?? null;

    if (!$uuid) {
        http_response_code(400);
        die('Note UUID is required.');
    }

    $noteResult = Notes::singleDetailed($uuid);

    // Security check for patients
    if ($userRole === 'patient' && $noteResult['success'] && !empty($noteResult['data'])) {
        if ($noteResult['data']['patient_uuid'] !== $userUuid) {
            http_response_code(403);
            die('Unauthorized to export this note.');
        }
    }

    if (!$noteResult['success'] || empty($noteResult['data'])) {
        http_response_code(404);
        die('Note not found.');
    }

    $data = $noteResult['data'];

    // Formatting Date
    $formattedDate = 'Unknown Date';
    if (!empty($data['sched_date'])) {
        $timestamp = strtotime($data['sched_date'] . ' ' . ($data['sched_time'] ?? '00:00:00'));
        $formattedDate = date('F j, Y \a\t g:i A', $timestamp);
    }

    $serviceName = htmlspecialchars($data['service_name'] ?? 'General Consultation');
    $doctorFullName = htmlspecialchars('Dr. ' . ($data['doctor_firstname'] ?? 'Unknown Provider') . ' ' . ($data['doctor_lastname'] ?? ''));
    $patientUuid = 'Patient ID: ' . htmlspecialchars($data['patient_uuid']);
    $patientName = htmlspecialchars(userData($data['patient_uuid'])['name']) ?? 'Unknown Patient';

    $subjective = htmlspecialchars($data['subjective'] ?? '-');
    $assessment = htmlspecialchars($data['assessment'] ?? '-');
    $plan = htmlspecialchars($data['plan'] ?? '-');

    // Parse Objective JSON
    $objectiveText = '-';
    $bp = '-';
    $hr = '-';
    $weight = '-';

    if (!empty($data['objective'])) {
        $objData = json_decode($data['objective'], true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $objectiveText = htmlspecialchars($objData['objective'] ?? '-');
            $bp = htmlspecialchars($objData['blood_pressure'] ?? '-');
            $hr = htmlspecialchars(!empty($objData['heart_rate']) ? $objData['heart_rate'] : '-');
            $weight = htmlspecialchars(!empty($objData['weight']) ? $objData['weight'] : '-');
        } else {
            $objectiveText = htmlspecialchars($data['objective']);
        }
    }

    $statusBadge = $data['status'] === 'signed' ? 'Completed' : ucfirst($data['status'] ?? 'Draft');

    // PDF HTML Content
    $html = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Clinical Note PDF Export - MindTrack</title>
            <style>
                body { 
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
                    color: #3f3f46; /* text-main */
                    line-height: 1.6; 
                    margin: 0; 
                    padding: 0;
                }
                h1, h2, h3, h4 { 
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
                }
                .a4-page {
                    width: 100%;
                }
                /* Header */
                .header-wrapper {
                    border-bottom: 2px solid rgba(71, 82, 235, 0.1); 
                    padding-bottom: 20px; 
                    margin-bottom: 30px; 
                    width: 100%;
                }
                .header-table { width: 100%; border-collapse: collapse; }
                .header-table td { vertical-align: top; }
                
                .logo-box {
                    background-color: #4752eb;
                    width: 56px;
                    height: 56px;
                    border-radius: 12px;
                    text-align: center;
                    color: white;
                    font-weight: bold;
                    font-size: 24px;
                    line-height: 56px;
                }
                
                .clinic-title {
                    font-size: 20px;
                    font-weight: bold;
                    color: #111827; /* gray-900 */
                    margin: 0 0 4px 0;
                    letter-spacing: -0.5px;
                }
                .clinic-address {
                    font-size: 12px;
                    color: #71717a; /* text-muted */
                    margin: 0;
                    line-height: 1.5;
                }
                
                .doc-control-box {
                    background-color: #f9fafb; /* gray-50 */
                    padding: 8px 16px;
                    border-radius: 8px;
                    border: 1px solid #f3f4f6;
                    text-align: right;
                }
                .doc-control-label {
                    font-size: 10px;
                    text-transform: uppercase;
                    font-weight: bold;
                    color: #4752eb;
                    letter-spacing: 1.5px;
                    margin: 0 0 4px 0;
                }
                .doc-control-id {
                    font-size: 12px;
                    font-family: monospace;
                    color: #4b5563; /* gray-600 */
                    margin: 0;
                }
                
                /* Title Section */
                .session-summary {
                    margin-bottom: 30px;
                }
                .doc-title {
                    font-size: 24px;
                    font-weight: bold;
                    color: #111827;
                    margin: 0 0 4px 0;
                }
                .doc-meta {
                    font-size: 14px;
                    color: #71717a;
                }
                .dot-divider {
                    display: inline-block;
                    width: 4px;
                    height: 4px;
                    background-color: #d1d5db;
                    border-radius: 50%;
                    margin: 0 8px;
                    vertical-align: middle;
                }
                .service-type {
                    color: #4752eb;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 10px;
                    letter-spacing: 1px;
                }
                
                /* Patient Info Box */
                .patient-info-box {
                    background-color: #f8fafc; /* gray-50/50 approx */
                    border: 1px solid #e5e7eb;
                    border-radius: 12px;
                    padding: 20px;
                    margin-bottom: 40px;
                }
                .patient-table { width: 100%; border-collapse: collapse; }
                .patient-table td { width: 33.33%; vertical-align: top; }
                .patient-label {
                    font-size: 10px;
                    font-weight: bold;
                    color: #71717a;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    margin: 0 0 4px 0;
                }
                .patient-value {
                    font-size: 14px;
                    font-weight: 600;
                    color: #111827;
                    margin: 0;
                    text-transform: capitalize;
                }
                
                /* SOAP Sections */
                .content-section {
                    margin-bottom: 32px;
                    page-break-inside: avoid;
                }
                .section-header {
                    border-bottom: 1px solid #f3f4f6;
                    padding-bottom: 8px;
                    margin-bottom: 12px;
                }
                .section-title {
                    font-size: 12px;
                    font-weight: bold;
                    color: #4752eb;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    margin: 0;
                }
                .section-body {
                    font-size: 14px;
                    line-height: 1.6;
                    color: #3f3f46;
                    white-space: pre-wrap;
                }
                
                /* Vitals Table */
                .vitals-table {
                    width: 100%;
                    text-align: left;
                    font-size: 14px;
                    border-collapse: collapse;
                    margin-bottom: 16px;
                }
                .vitals-table th {
                    padding: 8px 12px;
                    border: 1px solid #e5e7eb;
                    font-size: 10px;
                    font-weight: bold;
                    text-transform: uppercase;
                    color: #71717a;
                    background-color: #f9fafb;
                }
                .vitals-table td {
                    padding: 8px 12px;
                    border: 1px solid #e5e7eb;
                }
                .vital-value {
                    font-weight: 600;
                }
                .vital-unit {
                    color: #71717a;
                    font-size: 12px;
                }
                
                /* Footer */
                .signature-footer {
                    margin-top: 64px;
                    padding-top: 32px;
                    border-top: 1px solid #e5e7eb;
                    width: 100%;
                }
                .footer-table { width: 100%; border-collapse: collapse; }
                .footer-table td { vertical-align: bottom; }
                
                .footer-gen-label {
                    font-size: 9px;
                    color: #71717a;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    margin: 0 0 4px 0;
                }
                .footer-gen-date {
                    font-size: 10px;
                    color: #6b7280;
                    margin: 0;
                }
                
                .signature-box { text-align: right; }
                .signature-script {
                    font-family: 'Times New Roman', Times, serif;
                    font-style: italic;
                    font-size: 24px;
                    color: rgba(71, 82, 235, 0.7);
                    margin-bottom: 8px;
                }
                .signature-line {
                    height: 1px;
                    width: 256px;
                    background-color: #d1d5db;
                    margin-left: auto;
                    margin-bottom: 8px;
                }
                .doctor-name {
                    font-size: 14px;
                    font-weight: bold;
                    color: #111827;
                    margin: 0;
                }
                .doctor-creds {
                    font-size: 10px;
                    color: #71717a;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    margin: 0 0 8px 0;
                }
                .verified-badge {
                    font-size: 10px;
                    font-weight: bold;
                    text-transform: uppercase;
                    color: #059669; /* emerald-600 */
                    letter-spacing: -0.5px;
                }
                
                .doc-pagination {
                    text-align: center;
                    padding-top: 32px;
                    color: #6b7280;
                    font-size: 12px;
                    font-weight: 500;
                }
            </style>
        </head>
        <body>
            <div class="a4-page">
                <!-- Header -->
                <div class="header-wrapper">
                    <table class="header-table">
                        <tr>
                            <td style="width: 70px;">
                                <div class="logo-box">MT</div>
                            </td>
                            <td>
                                <h2 class="clinic-title">Wayside Psyche Resources Center</h2>
                                <p class="clinic-address">
                                    2nd Floor, AFG Bldg, C. De Jesus St, Poblacion<br>
                                    Sta. Maria, Bulacan<br>
                                    Contact: 0933 586 5859 | wayside.inquiries@gmail.com
                                </p>
                            </td>
                            <td style="text-align: right; width: 200px;">
                                <div class="doc-control-box">
                                    <p class="doc-control-label">Document Control</p>
                                    <p class="doc-control-id">ID: {$uuid}</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Session Summary -->
                <div class="session-summary">
                    <h1 class="doc-title">CLINICAL SESSION SUMMARY</h1>
                    <div class="doc-meta">
                        {$formattedDate} <span class="dot-divider"></span> 
                        <span class="service-type">{$serviceName}</span> <span class="dot-divider"></span> 
                        <span style="font-weight: 600;">Status: {$statusBadge}</span>
                    </div>
                </div>

                <!-- Patient Grid -->
                <div class="patient-info-box">
                    <table class="patient-table">
                        <tr>
                            <td>
                                <p class="patient-label">Patient Name</p>
                                <p class="patient-value">{$patientName}</p>
                            </td>
                            <td>
                                <p class="patient-label">Medical Record Number</p>
                                <p class="patient-value">{$patientUuid}</p>
                            </td>
                            <td>
                                <p class="patient-label">Provider</p>
                                <p class="patient-value">{$doctorFullName}</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="flex: 1;">
                    <!-- Subjective -->
                    <div class="content-section">
                        <div class="section-header">
                            <h3 class="section-title">Subjective</h3>
                        </div>
                        <div class="section-body">{$subjective}</div>
                    </div>

                    <!-- Objective -->
                    <div class="content-section">
                        <div class="section-header">
                            <h3 class="section-title">Objective</h3>
                        </div>
                        
                        <table class="vitals-table">
                            <thead>
                                <tr>
                                    <th>Measurement</th>
                                    <th>Result</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 500;">Blood Pressure</td>
                                    <td class="vital-value">{$bp}</td>
                                    <td class="vital-unit">mmHg</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Heart Rate</td>
                                    <td class="vital-value">{$hr}</td>
                                    <td class="vital-unit">bpm</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Body Weight</td>
                                    <td class="vital-value">{$weight}</td>
                                    <td class="vital-unit">kg</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="section-body">{$objectiveText}</div>
                    </div>

                    <!-- Assessment -->
                    <div class="content-section">
                        <div class="section-header">
                            <h3 class="section-title">Assessment</h3>
                        </div>
                        <div class="section-body">{$assessment}</div>
                    </div>

                    <!-- Plan -->
                    <div class="content-section">
                        <div class="section-header">
                            <h3 class="section-title">Plan</h3>
                        </div>
                        <div class="section-body">{$plan}</div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="signature-footer">
                    <table class="footer-table">
                        <tr>
                            <td>
                                <p class="footer-gen-label">Generation Date</p>
                                <p class="footer-gen-date">{$formattedDate}</p>
                            </td>
                            <td class="signature-box">
                                <div class="signature-script">{$doctorFullName}</div>
                                <div class="signature-line"></div>
                                <p class="doctor-name">{$doctorFullName}</p>
                                <p class="doctor-creds">Attending Physician</p>
                                <div class="verified-badge">✔ Digitally Signed & Verified</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="doc-pagination">
                    Confidential Patient Record — Generated by MindTrack Clinical Systems
                </div>
            </div>
        </body>
        </html>
    HTML;

    // Output PDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', false);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream("Clinical_Note_{$uuid}.pdf", ["Attachment" => true]);
    exit;
}

http_response_code(405);
die('Invalid request method.');
