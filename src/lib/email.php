<?php

namespace Mindtrack\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Email
{
    // Email service implementation
    public static function sendVerificationEmail($email, $firstName, $lastName, $verificationToken)
    {
        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);
        global $config;

        try {
            // DEVELOPMENT MODE
            // This will log the email details but not actually send it
            // For development/testing without actual email sending
            $devMode = false;  // Set to false when you have SMTP credentials
            if ($devMode) {
                // Log verification info and return true to simulate successful sending
                error_log("Development mode: Email would be sent to: {$email} with uuid: {$verificationToken}");
                error_log("Verification URL would be: https://" . $_SERVER['HTTP_HOST'] . "/app/auth/verification.php?uuid=" . $verificationToken);
                return [
                    'success' => true,
                    'message' => "Verification email sent successfully"
                ];
            }

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'juanwork.root@gmail.com';  // Your Gmail address
            $mail->Password = 'ahqzklzppbtotknz';      // Your Gmail App Password (16 characters, no spaces)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('juanwork.root@gmail.com', 'Mindtrack');  // Use your Gmail address
            $mail->addAddress($email, $firstName . ' ' . $lastName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Mindtrack Account';

            // Create verification URL
            $verificationUrl = $config['app']['base_url'] . '/src/app/auth/verification.php?uuid=' . $verificationToken;

            // Email body
            $mail->Body = <<<HTML
                <!DOCTYPE html>
                <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                color: #333;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                border: 1px solid #ddd;
                                border-radius: 5px;
                            }
                            .header {
                                background-color: #6d28d9;
                                color: white;
                                padding: 15px;
                                text-align: center;
                                border-radius: 5px 5px 0 0;
                            }
                            .content {
                                padding: 20px;
                            }
                            .button {
                                display: inline-block;
                                background-color: #6d28d9;
                                color: white !important;
                                padding: 10px 20px;
                                text-decoration: none;
                                border-radius: 5px;
                                margin: 20px 0;
                            }
                            .footer {
                                text-align: center;
                                margin-top: 20px;
                                font-size: 12px;
                                color: #777;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <h2>MindTrack</h2>
                            </div>
                            <div class="content">
                                <h3>Hello {$firstName} {$lastName},</h3>
                                <p>Thank you for registering with MindTrack. To complete your registration and activate your account, please verify your email address by clicking the button below:</p>
                                
                                <p style="text-align: center;">
                                    <a href="{$verificationUrl}" class="button">Verify Email Address</a>
                                </p>
                                
                                <p>If you did not create an account, no further action is required.</p>
                                
                                <p>If you're having trouble clicking the button, copy and paste the following link into your web browser:</p>
                                <p>{$verificationUrl}</p>
                                
                                <p>Thank you,<br>The MindTrack Team</p>
                            </div>
                            <div class="footer">
                                <p>&copy; 2024 MindTrack. All rights reserved.</p>
                            </div>
                        </div>
                    </body>
                </html>
HTML;

            // Plain text version for non-HTML mail clients
            $mail->AltBody = "Hello $firstName $lastName,\n\n"
                . "Thank you for registering with Mindtrack. To verify your email address, please visit the following link:\n"
                . "$verificationUrl\n\n"
                . "If you did not create an account, no further action is required.\n\n"
                . "Thank you,\nThe Mindtrack Team";

            $mail->send();
            error_log("✅ Verification email sent successfully to: {$email}");
            return [
                'success' => true,
                'message' => "Verification email sent successfully"
            ];
        } catch (Exception $e) {
            error_log("❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            error_log("Exception Message: " . $e->getMessage());
            error_log("Recipient: {$email}");
            return [
                'success' => false,
                'message' => "Email could not be sent",
                'error' => $mail->ErrorInfo
            ];
        }
    }
}
