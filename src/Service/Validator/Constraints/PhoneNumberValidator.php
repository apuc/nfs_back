<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Значение должно содержать 11S цифр, начинаться с 79.
 */
class PhoneNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match('/79[0-9]{9}$/', (string) $value)) {
            /* @phpstan-ignore-next-line */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parameter }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }
}
