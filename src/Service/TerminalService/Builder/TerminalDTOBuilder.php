<?php

declare(strict_types=1);

namespace App\Service\TerminalService\Builder;

use App\Entity\Terminal;
use App\Service\TerminalService\DTO\TerminalDTO;

class TerminalDTOBuilder
{
    public static function build(Terminal $terminal = null): ?TerminalDTO
    {
        if (null === $terminal) {
            return null;
        }

        return (new TerminalDTO())
            ->setId($terminal->getId())
            ->setTitle($terminal->getTitle())
            ->setSerial($terminal->getSerial())
            ->setModelName($terminal->getModelName())
            ->setSimCardNumber($terminal->getSimCardNumber())
            ->setMcamCardNumber($terminal->getMcamCardNumber())
            ->setStatus($terminal->getStatus())
            ->setHash($terminal->getHash())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($terminal->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($terminal->getUpdatedAt()));
    }
}
