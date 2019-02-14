<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
final class PersonalFunctionsValidator extends ConstraintValidator
{
    public $availableFunctions = ['Pilot', 'Copilot', 'Steward', 'Hostess'];

    public function validate($value, Constraint $constraint): void
    {
        if(!in_array(ucfirst($value), $this->availableFunctions))
        {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}