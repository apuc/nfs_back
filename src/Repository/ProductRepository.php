<?php

declare(strict_types=1);

namespace App\Repository;

use App\Base\Traits\DBTrait;
use App\Entity\Product;
use App\Service\ProductService\Constants\ProductConstants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    use DBTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllNotRemoved(): iterable
    {
        return $this->createQueryBuilder('product')
            ->where('product.status != :removedStatus')
            ->setParameter('removedStatus', ProductConstants::STATUS_REMOVED)
            ->getQuery()
            ->toIterable();
    }

    public function findNotRemovedByPackageId(int $packageId): array
    {
        return $this->createQueryBuilder('product')
            ->where('product.status != :removedStatus')
            ->andWhere('product.package = :package')
            ->setParameter('removedStatus', ProductConstants::STATUS_REMOVED)
            ->setParameter('package', $packageId)
            ->getQuery()
            ->getScalarResult();
    }

    public function findProductByHash(string $hash): ?Product
    {
        return $this->findOneBy(['hash' => $hash]);
    }
}
