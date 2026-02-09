<?php
namespace Mindtrack\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Login
{
    public static function validate(array $data)
    {
        $validator = v::key('email', v::email())
            ->key('password', v::stringType()->notEmpty());

        try {
            $validator->assert($data);
            return [
                'valid' => true,
                'data' => [
                    'email' => $data['email'],
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
