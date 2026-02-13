<?php

namespace Mindtrack\Features\Services\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Services
{
    public static function validate($data)
    {
        $validator = v::key('name', v::stringType()->notEmpty())
            ->key('category', v::stringType()->notEmpty())
            ->key('price', v::numericVal()->min(0))
            ->key('duration', v::intVal()->min(0)) // Duration in minutes
            ->key('description', v::optional(v::stringType()))
            ->key('specialization_id', v::optional(v::nullable(v::numericVal())));

        // If 'active' checkbox is sent, it might not be in $data if not checked, or might be 'on'.
        // The validator keys check for PRESENCE. optional() allows key to be missing or null.
        // We really just want to valid the scalar values we expect.

        try {
            // We only validate the fields we care about, ignoring extras (like 'action', 'uuid') 
            // unless we want strict checking. default `assert` allows extra keys? 
            // No, `key` by default doesn't complain about extra keys unless `keySet` is used.
            // But we want to check strictness? No, loose is fine.

            $validator->assert($data);

            return [
                'valid' => true,
                'data' => [
                    'name' => trim($data['name']),
                    'category_id' => trim($data['category']),
                    'description' => trim($data['description'] ?? ''),
                    'price' => (float) $data['price'],
                    'duration' => (int) ($data['duration'] ?? 60),
                    'status' => isset($data['status']) && $data['status'] === 'active' ? 'active' : 'inactive',
                    'specialization_id' => !empty($data['specialization_id']) ? (int) $data['specialization_id'] : null,
                    'uuid' => $data['uuid'] ?? null
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
