<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * N – численные данные включают символы от 0 до 9. Допускаются
 * только целые числа (1, 10, 100). Использование десятичных дробей
 * и/или показателей степени не допускается.
 */
class ContainsOnlyDigitsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match('/^[0-9]+$/', (string) $value)) {
            /* @phpstan-ignore-next-line */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parameter }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }
}
