<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Значение не должно быть пустым, содержать пустой массив или иметь значение NULL.
 */
class NotEmptyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || (empty($value) && '0' != $value)) {
            /* @phpstan-ignore-next-line */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parameter }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }
}
