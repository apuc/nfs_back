<?php

declare(strict_types=1);

namespace App\Repository;

use App\Base\Traits\DBTrait;
use App\Entity\Terminal;
use App\Service\TerminalService\Constants\TerminalConstants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Terminal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terminal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terminal[]    findAll()
 * @method Terminal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerminalRepository extends ServiceEntityRepository
{
    use DBTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terminal::class);
    }

    public function findAllNotRemoved(): iterable
    {
        return $this->createQueryBuilder('terminal')
            ->where('terminal.status != :removedStatus')
            ->setParameter('removedStatus', TerminalConstants::STATUS_REMOVED)
            ->getQuery()
            ->toIterable();
    }

    public function findTerminalByHash(string $hash): ?Terminal
    {
        return $this->findOneBy(['hash' => $hash]);
    }

    public function findTerminalById(int $id): ?Terminal
    {
        return $this->findOneBy(['id' => $id]);
    }
}
