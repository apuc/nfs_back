<?php

declare(strict_types=1);

namespace App\Repository;

use App\Base\Traits\DBTrait;
use App\Entity\ProductPackage;
use App\Service\ProductService\Constants\ProductConstants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductPackage[]    findAll()
 * @method ProductPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductPackageRepository extends ServiceEntityRepository
{
    use DBTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPackage::class);
    }

    public function findAllNotRemoved(): iterable
    {
        return $this->createQueryBuilder('productPackage')
            ->where('productPackage.status != :removedStatus')
            ->setParameter('removedStatus', ProductConstants::STATUS_REMOVED)
            ->getQuery()
            ->toIterable();
    }

    public function findProductPackageByHash(string $hash): ?ProductPackage
    {
        return $this->findOneBy(['hash' => $hash]);
    }
}
