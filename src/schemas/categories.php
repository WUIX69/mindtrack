<?php

namespace Mindtrack\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Categories
{
    public static function validate($data)
    {
        $validator = v::key('name', v::stringType()->notEmpty())
            ->key('reference_model', v::stringType()->notEmpty())
            ->key('status', v::stringType()->notEmpty()) // 'active' or 'inactive'
            ->key('icon', v::optional(v::stringType()))
            ->key('description', v::optional(v::stringType()));

        try {
            $validator->assert($data);

            return [
                'valid' => true,
                'data' => [
                    'name' => trim($data['name']),
                    'reference_model' => trim($data['reference_model']),
                    'icon' => trim($data['icon'] ?? ''),
                    'description' => trim($data['description'] ?? ''),
                    'status' => trim($data['status']),
                    'id' => $data['id'] ?? null // Carry over ID if present (for updates)
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
