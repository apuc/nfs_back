<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use App\Service\TerminalService\TerminalService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Значение должно содержать наименование города, которое существует в справочнике.
 */
class TerminalExistsValidator extends ConstraintValidator
{
    public function __construct(private TerminalService $terminalService)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->terminalService->findDTOById($value)) {
            /* @phpstan-ignore-next-line */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parameter }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }
}