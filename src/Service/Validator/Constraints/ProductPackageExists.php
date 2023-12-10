<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class ProductPackageExists extends Constraint
{
    public string $message = '`{{ parameter }}` must contain legal identifier of product package.';
}
