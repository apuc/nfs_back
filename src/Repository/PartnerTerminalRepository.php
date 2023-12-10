<?php

declare(strict_types=1);

namespace App\Repository;

use App\Base\Traits\DBTrait;
use App\Entity\PartnerTerminal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PartnerTerminal|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnerTerminal|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnerTerminal[]    findAll()
 * @method PartnerTerminal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnerTerminalRepository extends ServiceEntityRepository
{
    use DBTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnerTerminal::class);
    }
}
