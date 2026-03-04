<?php
namespace Mindtrack\Features\Settings\Schemas;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Deactivation
{
    public static function validate(array $data)
    {
        $validator = v::key('deactivation_reason', v::stringType()->notEmpty()->length(1, 255))
            ->key('other_feedback', v::optional(v::stringType()->length(0, 1000)), false)
            ->key('confirmation', v::stringType()->notEmpty()->regex('/^deactivate$/i'));

        try {
            $validator->assert($data);
            return [
                'valid' => true,
                'data' => [
                    'reason' => $data['deactivation_reason'],
                    'feedback' => $data['other_feedback'] ?? null,
                    'confirmation' => $data['confirmation']
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
