<?php
namespace Mindtrack\Features\Settings\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class DoctorSettings
{
    public static function validate(array $data)
    {
        $validator = v::key('firstname', v::stringType()->notEmpty())
            ->key('lastname', v::stringType()->notEmpty())
            ->key('email', v::email())
            ->key('phone', v::optional(v::stringType()), false)
            ->key('specialization_id', v::optional(v::intVal()), false)
            ->key('license_number', v::optional(v::stringType()), false)
            ->key('bio', v::optional(v::stringType()), false)
            ->key('availability', v::optional(v::stringType()), false)
            ->key('consultation_fee', v::optional(v::numericVal()), false);

        try {
            $validator->assert($data);
            return [
                'valid' => true,
                'data' => [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?: null,
                    'specialization_id' => !empty($data['specialization_id']) ? (int) $data['specialization_id'] : null,
                    'license_number' => !empty($data['license_number']) ? $data['license_number'] : null,
                    'bio' => !empty($data['bio']) ? $data['bio'] : null,
                    'availability' => !empty($data['availability']) ? $data['availability'] : null,
                    'consultation_fee' => !empty($data['consultation_fee']) ? (float) $data['consultation_fee'] : 0.00,
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
