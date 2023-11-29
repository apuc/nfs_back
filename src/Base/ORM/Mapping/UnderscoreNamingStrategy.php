<?php

declare(strict_types=1);

namespace App\Base\ORM\Mapping;

use Doctrine\ORM\Mapping\NamingStrategy;

class UnderscoreNamingStrategy implements NamingStrategy
{
    private const DEFAULT_PATTERN = '/(?<=[a-z])([A-Z])/';
    private const NUMBER_AWARE_PATTERN = '/(?<=[a-z0-9])([A-Z])/';

    private int $case;

    private string $pattern;

    /**
     * Underscore naming strategy construct.
     *
     * @param int $case CASE_LOWER | CASE_UPPER
     */
    public function __construct(int $case = CASE_LOWER, bool $numberAware = true)
    {
        if (!$numberAware) {
            @trigger_error(
                'Creating '.self::class.' without making it number aware is deprecated and will be removed in Doctrine ORM 3.0.',
                E_USER_DEPRECATED
            );
        }

        $this->case = $case;
        $this->pattern = $numberAware ? self::NUMBER_AWARE_PATTERN : self::DEFAULT_PATTERN;
    }

    /**
     * @return int CASE_LOWER | CASE_UPPER
     */
    public function getCase(): int
    {
        return $this->case;
    }

    /**
     * Sets string case CASE_LOWER | CASE_UPPER.
     * Alphabetic characters converted to lowercase or uppercase.
     */
    public function setCase(int $case): void
    {
        $this->case = $case;
    }

    public function classToTableName($className): string
    {
        $contextName = null;
        if (str_contains($className, '\\')) {
            if (false !== $entityPosition = strrpos($className, 'Entity')) {
                $firstPart = substr($className, 0, $entityPosition - 1);
                $contextName = substr($firstPart, strpos($firstPart, '\\') + 1);
            }
            $className = $contextName.substr($className, strrpos($className, '\\') + 1);
        }

        if ($className === $contextName.$contextName) {
            $className = $contextName;
        }

        return $this->underscore((string) $className);
    }

    public function propertyToColumnName($propertyName, $className = null): string
    {
        return $this->underscore($propertyName);
    }

    public function embeddedFieldToColumnName(
        $propertyName,
        $embeddedColumnName,
        $className = null,
        $embeddedClassName = null
    ): string {
        return $this->underscore($propertyName).'_'.$embeddedColumnName;
    }

    public function referenceColumnName(): string
    {
        return CASE_UPPER === $this->case ? 'ID' : 'id';
    }

    /**
     * @param string $propertyName
     */
    public function joinColumnName($propertyName, string $className = null): string
    {
        return $this->underscore($propertyName).'_'.$this->referenceColumnName();
    }

    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null): string
    {
        return $this->classToTableName($sourceEntity).'_'.$this->classToTableName($targetEntity);
    }

    public function joinKeyColumnName($entityName, $referencedColumnName = null): string
    {
        return $this->classToTableName($entityName).'_'.
               ($referencedColumnName ?: $this->referenceColumnName());
    }

    private function underscore(string $string): string
    {
        /** @var string $string */
        $string = preg_replace($this->pattern, '_$1', $string);

        if (\CASE_UPPER === $this->case) {
            return strtoupper($string);
        }

        return strtolower($string);
    }
}
