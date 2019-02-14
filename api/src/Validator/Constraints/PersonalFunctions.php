<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PersonalFunctions extends Constraint
{
    public $message = 'This function is not one of the available function as a Personal';
}