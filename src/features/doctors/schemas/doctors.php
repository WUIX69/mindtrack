<?php
namespace Mindtrack\Features\Doctors\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Doctors
{
    public static function validate(array $data)
    {
        // Define validation rules
        $validator = v::key('firstname', v::stringType()->notEmpty())
            ->key('lastname', v::stringType()->notEmpty())
            ->key('email', v::email()->notEmpty())
            ->key('phone', v::optional(v::stringType()))
            ->key('specialty', v::optional(v::stringType())) // optional as we might use ID or it might be free text handled by backend
            ->key('license_number', v::optional(v::stringType()))
            ->key('bio', v::optional(v::stringType()))
            ->key('availability', v::optional(v::arrayType())); // Expecting array for availability

        // Password is required for creation, maybe optional for update?
        // Let's handle password separate or make it optional here and check in logic if needed.
        // For 'create', we usually require it.
        // But this schema might be used for both.
        // Reference `appointment.php` doesn't have conditional logic inside.
        // I'll add password as optional here and handle 'required' check in the Action if needed,
        // OR make two methods `validateCreate` and `validateUpdate`.
        // User asked to use `doctors.php` schema.
        // I will add `validateCreate` and `validateUpdate`.

        // Actually, simple `validate` is standard. I'll make password optional in the schema 
        // and strictly check it in the Create Action if missing.
        $validator->key('password', v::optional(v::stringType()->length(6, null)));

        try {
            $validator->assert($data);

            // Clean/Return data
            return [
                'valid' => true,
                'data' => [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?: null,
                    'specialty' => $data['specialty'] ?: null,
                    'license_number' => $data['license_number'] ?: null,
                    'bio' => $data['bio'] ?: null,
                    'availability' => $data['availability'] ?: [],
                    'password' => $data['password'] ?: null,
                    'uuid' => $data['uuid'] ?? $data['doctor_uuid'] ?? null // Handle both just in case
                ]
            ];
        } catch (NestedValidationException $e) {
            return [
                'valid' => false,
                'errors' => $e->getMessages()
            ];
        }
    }
}
