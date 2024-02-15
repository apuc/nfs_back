<?php

declare(strict_types=1);

namespace App\Service\TerminalService;

use App\Entity\Terminal;
use App\Repository\TerminalRepository;

class TerminalService
{

    public function __construct(private TerminalRepository $terminalRepository)
    {

    }

    public function findDTOById(int $terminal_id): Terminal
    {
        return $this->terminalRepository->findOneBy(['id' => $terminal_id]);
    }

    public function findEntityById(int $id): ?Terminal
    {
        return $this->terminalRepository->findTerminalById($id);
    }

}
