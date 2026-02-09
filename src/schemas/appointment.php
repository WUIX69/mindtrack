<?php
namespace Mindtrack\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Appointment
{
    public static function validate(array $data)
    {
        $validator = v::key('service_uuid', v::uuid())
            ->key('doctor_uuid', v::uuid())
            ->key('sched_date', v::date('Y-m-d'))
            ->key('sched_time', v::stringType()->notEmpty())
            ->key('notes', v::optional(v::stringType()));

        try {
            $validator->assert($data);
            return [
                'valid' => true,
                'data' => [
                    'service_uuid' => $data['service_uuid'],
                    'doctor_uuid' => $data['doctor_uuid'],
                    'sched_date' => $data['sched_date'],
                    'sched_time' => $data['sched_time'],
                    'notes' => $data['notes'] ?? null
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
