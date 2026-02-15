<?php
namespace Mindtrack\Features\Patients\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Patients
{
    public static function validate(array $data)
    {
        // Define validation rules
        $validator = v::key('firstname', v::stringType()->notEmpty())
            ->key('lastname', v::stringType()->notEmpty())
            ->key('email', v::email()->notEmpty())
            ->key('phone', v::optional(v::stringType()))
            ->key('status', v::optional(v::in(['active', 'inactive'])))
            ->key('date_of_birth', v::optional(v::date()))
            ->key('gender', v::optional(v::in(['male', 'female', 'other'])))
            ->key('address', v::optional(v::stringType()))
            ->key('emergency_contact_name', v::optional(v::stringType()))
            ->key('emergency_contact_phone', v::optional(v::stringType()))
            ->key('conditions', v::optional(v::stringType()))
            ->key('allergies', v::optional(v::stringType()))
            ->key('alerts', v::optional(v::arrayType()))
            ->key('password', v::optional(v::stringType()->length(6, null)))
            ->key('uuid', v::optional(v::stringType()));

        try {
            $validator->assert($data);

            // Clean/Return data structure as expected by backend
            return [
                'valid' => true,
                'data' => [
                    'uuid' => $data['uuid'] ?? null,
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?: null,
                    'status' => $data['status'] ?? 'active',
                    'date_of_birth' => $data['date_of_birth'] ?: null,
                    'gender' => $data['gender'] ?: null,
                    'address' => $data['address'] ?: '',
                    'emergency_contact_name' => $data['emergency_contact_name'] ?: '',
                    'emergency_contact_phone' => $data['emergency_contact_phone'] ?: '',
                    'medical_history' => [
                        'conditions' => $data['conditions'] ?? '',
                        'allergies' => $data['allergies'] ?? '',
                        'alerts' => $data['alerts'] ?? []
                    ],
                    'password' => $data['password'] ?? null
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
