<?php
namespace Mindtrack\Features\Settings\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Settings
{
    public static function validate(array $data)
    {
        $validator = v::key('firstname', v::stringType()->notEmpty())
            ->key('lastname', v::stringType()->notEmpty())
            ->key('email', v::email())
            ->key('phone', v::optional(v::stringType()), false)
            ->key('date_of_birth', v::optional(v::date()), false)
            ->key('gender', v::optional(v::in(['male', 'female', 'other', 'prefer not to say'])), false)
            ->key('address', v::optional(v::stringType()), false)
            ->key('emergency_contact_name', v::optional(v::stringType()), false)
            ->key('emergency_contact_phone', v::optional(v::stringType()), false);

        try {
            $validator->assert($data);
            return [
                'valid' => true,
                'data' => [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?: null,
                    'date_of_birth' => !empty($data['date_of_birth']) ? $data['date_of_birth'] : null,
                    'gender' => $data['gender'] ?: null,
                    'address' => $data['address'] ?: null,
                    'emergency_contact_name' => $data['emergency_contact_name'] ?: null,
                    'emergency_contact_phone' => $data['emergency_contact_phone'] ?: null,
                ]
            ];
        } catch (NestedValidationException $e) {
            return [
                'valid' => false,
                'errors' => $e->getMessages() // Returns an array of messages
            ];
        }
    }
}
