<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PhoneNumber extends Constraint
{
    public string $message = '`{{ parameter }}` must contain 11 digits starting with `7`.';
}
