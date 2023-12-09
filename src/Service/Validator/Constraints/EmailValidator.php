<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Значение должно содержать валидный адрес электронной почты.
 */
class EmailValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            /* @phpstan-ignore-next-line */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parameter }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }
}
