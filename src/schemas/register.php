<?php
namespace Mindtrack\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Register
{
    public static function validate(array $data)
    {
        $validator = v::key('firstname', v::stringType()->notEmpty()->length(1, 50))
            ->key('lastname', v::stringType()->notEmpty()->length(1, 50))
            ->key('email', v::email())
            ->key('password', v::stringType()->notEmpty()->length(8, null))
            ->key('phone', v::optional(v::phone()), true);

        try {
            $validator->assert($data);
            return [
                'valid' => true,
                'data' => [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'phone' => trim($data['phone']) ?: null,
                    'password' => $data['password']
                ]
            ];
        } catch (NestedValidationException $e) {
            return [
                'valid' => false,
                'errors' => $e->getFullMessage()
            ];
        }
    }
}
