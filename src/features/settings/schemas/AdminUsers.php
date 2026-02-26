<?php
namespace Mindtrack\Features\Settings\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class AdminUsers
{
    public static function validate(array $data)
    {
        // Define validation rules
        $validator = v::key('firstname', v::stringType()->notEmpty(), true)
            ->key('lastname', v::stringType()->notEmpty(), true)
            ->key('email', v::email()->notEmpty(), true)
            ->key('phone', v::optional(v::stringType()), false)
            ->key('status', v::optional(v::in(['active', 'inactive'])), false)
            ->key('is_email_verified', v::optional(v::in(['0', '1', 0, 1, true, false])), false)
            ->key('password', v::optional(v::stringType()->length(6, null)), false)
            ->key('uuid', v::optional(v::stringType()), false);

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
                    'is_email_verified' => isset($data['is_email_verified']) ? (int) $data['is_email_verified'] : 0,
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
