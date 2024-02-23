<?php

declare(strict_types=1);

namespace App\Service\Validator\Constraints;

use App\Service\OrderService\OrderService;
use App\Service\ProductService\ProductService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Значение должно содержать идентификатор существующего пакета услуг.
 */
class OrderExistsValidator extends ConstraintValidator
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->orderService->findEntityById($value)) {
            /* @phpstan-ignore-next-line */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parameter }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }
}
