<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Grocery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Grocery>
 */
class GroceryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grocery::class);
    }

    public function getResult(QueryBuilder $queryBuilder): mixed
    {
        return $queryBuilder->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function add(Grocery $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param array<int, array{id: int, name: string, type: string, quantity: int}> $data
     */
    public function addMultipleItems(array $data): void
    {
        foreach ($data as $item) {
            $grocery = new Grocery();
            $grocery->setName($item['name']);
            $grocery->setType($item['type']);
            $grocery->setQuantity($item['quantity']);

            $this->getEntityManager()->persist($grocery);
        }

        $this->getEntityManager()->flush();
    }

    public function remove(Grocery $item, bool $flush = true): void
    {
        $this->getEntityManager()->remove($item);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function setNameFilter(QueryBuilder $queryBuilder, string $name): QueryBuilder
    {
        return $queryBuilder->andWhere('g.name LIKE :name')
            ->setParameter('name', '%'.$name.'%');
    }

    public function setTypeFilter(QueryBuilder $queryBuilder, string $type): QueryBuilder
    {
        return $queryBuilder->andWhere('g.type = :type')
            ->setParameter('type', $type);
    }

    public function setMinQuantityFilter(QueryBuilder $queryBuilder, int|string $minQuantity): QueryBuilder
    {
        return $queryBuilder->andWhere('g.quantity >= :minQuantity')
            ->setParameter('minQuantity', $minQuantity);
    }

    public function setMaxQuantityFilter(QueryBuilder $queryBuilder, int|string $maxQuantity): QueryBuilder
    {
        return $queryBuilder->andWhere('g.quantity <= :maxQuantity')
            ->setParameter('maxQuantity', $maxQuantity);
    }

    public function getGroceriesList(string $type, ?int $minQuantity, ?int $maxQuantity): mixed
    {
        $queryBuilder = $this->createQueryBuilder('g');
        $queryBuilder
            ->where('g.type = :type')
            ->setParameter('type', $type);
        if (!is_null($minQuantity)) {
            $queryBuilder = $this->setMinQuantityFilter($queryBuilder, $minQuantity);
        }

        if (!is_null($maxQuantity)) {
            $queryBuilder = $this->setMaxQuantityFilter($queryBuilder, $maxQuantity);
        }

        return $this->getResult($queryBuilder);
    }
}
