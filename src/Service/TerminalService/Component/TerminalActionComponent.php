<?php

declare(strict_types=1);

namespace App\Service\TerminalService\Component;

use App\DTO\Request\TerminalCreateDTO;
use App\DTO\Request\TerminalEditDTO;
use App\Entity\Terminal;
use App\Repository\TerminalRepository;
use App\Service\TerminalService\Builder\TerminalDTOBuilder;
use App\Service\TerminalService\Constants\TerminalConstants;
use App\Service\TerminalService\DTO\TerminalDTO;
use Psr\Log\LoggerInterface;

class TerminalActionComponent
{
    public function __construct(
        private TerminalRepository $repository,
        private LoggerInterface $terminalLogger,
    ) {
    }

    /**
     * @return TerminalDTO[]
     */
    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAllNotRemoved() as $terminal) {
            $result[] = TerminalDTOBuilder::build($terminal);
        }

        return $result;
    }

    public function view(int $identifier): ?TerminalDTO
    {
        return TerminalDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function create(TerminalCreateDTO $requestDTO): TerminalDTO
    {
        $terminal = $this->repository->findTerminalByHash($requestDTO->getHash());

        if (null === $terminal) {
            $terminal = (new Terminal())
                ->setTitle($requestDTO->getTitle())
                ->setSerial($requestDTO->getSerial())
                ->setModelName($requestDTO->getModelName())
                ->setSimCardNumber($requestDTO->getSimCardNumber())
                ->setMcamCardNumber($requestDTO->getMcamCardNumber())
                ->setStatus(TerminalConstants::STATUS_ACTIVE)
                ->setHash($requestDTO->getHash());

            $this->repository->save($terminal);
        }

        return TerminalDTOBuilder::build($terminal);
    }

    public function edit(TerminalEditDTO $requestDTO): TerminalDTO
    {
        $terminal = $this->repository->findOneBy(['id' => $requestDTO->getId()]);

        if (null !== $terminal) {
            $terminal
                ->setTitle($requestDTO->getTitle() ?? $terminal->getTitle())
                ->setSerial($requestDTO->getSerial() ?? $terminal->getSerial())
                ->setModelName($requestDTO->getModelName() ?? $terminal->getModelName())
                ->setSimCardNumber($requestDTO->getSimCardNumber() ?? $terminal->getSimCardNumber())
                ->setMcamCardNumber($requestDTO->getMcamCardNumber() ?? $terminal->getMcamCardNumber());

            $this->repository->save($terminal);
        }

        return TerminalDTOBuilder::build($terminal);
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $terminal = $this->repository->findOneBy(['id' => $identifier]);
            if (null !== $terminal) {
                $terminal->setStatus(TerminalConstants::STATUS_REMOVED);

                $this->repository->save($terminal);
            }

            return true;
        } catch (\Throwable $exception) {
            $this->terminalLogger->critical(
                'Error when terminal remove: '.$exception->getMessage(),
                [
                    'identifier' => $identifier,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return false;
        }
    }
}
