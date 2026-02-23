<?php

namespace Mindtrack\Features\Notes\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Notes
{
    public static function validate(array $data)
    {
        $validator = v::key('appointment_uuid', v::stringType()->notEmpty())
            ->key('patient_uuid', v::stringType()->notEmpty())
            ->key('uuid', v::optional(v::stringType()))
            ->key('subjective', v::optional(v::stringType()))
            ->key('objective', v::optional(v::stringType()))
            ->key('blood_pressure', v::optional(v::stringType()))
            ->key('heart_rate', v::optional(v::stringType()))
            ->key('weight', v::optional(v::stringType()))
            ->key('assessment', v::optional(v::stringType()))
            ->key('plan', v::optional(v::stringType()))
            ->key('status', v::optional(v::in(['draft', 'signed'])));

        try {
            $validator->assert($data);

            $objectiveData = [
                'blood_pressure' => $data['blood_pressure'] ?? '',
                'heart_rate' => $data['heart_rate'] ?? '',
                'weight' => $data['weight'] ?? '',
                'objective' => $data['objective'] ?? ''
            ];
            $objectiveJson = json_encode($objectiveData);

            return [
                'valid' => true,
                'data' => [
                    'uuid' => $data['uuid'] ?? null,
                    'appointment_uuid' => $data['appointment_uuid'],
                    'patient_uuid' => $data['patient_uuid'],
                    'subjective' => $data['subjective'] ?: null,
                    'objective' => $objectiveJson, // Store combined objective as JSON
                    'assessment' => $data['assessment'] ?: null,
                    'plan' => $data['plan'] ?: null,
                    'status' => $data['status'] ?? 'draft'
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
