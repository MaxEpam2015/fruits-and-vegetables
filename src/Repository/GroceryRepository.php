<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Grocery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class GroceryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grocery::class);
    }

    public function findByType(string $type)
    {
        return $this->createQueryBuilder('g')
            ->where('g.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    public function findByTypeAndId(string $type, int|string $id)
    {
        return $this->createQueryBuilder('g')
            ->where('g.type = :type')
            ->andWhere('g.id = :id')
            ->setParameter('type', $type)
            ->setParameter('id' ,$id )
            ->getQuery()
            ->getResult();
    }

    public function getResult(QueryBuilder $queryBuilder)
    {
        return
            $queryBuilder->getQuery()->getResult();
    }

    public function add(Grocery $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

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

    public function findByName(string $name)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function setNameFilter(QueryBuilder $queryBuilder, string $name): QueryBuilder
    {
        return $queryBuilder->andWhere('g.name LIKE :name')
            ->setParameter('name', '%' . $name . '%');
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

    public function findByQuantityRange(int $min, int $max)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.quantity BETWEEN :min AND :max')
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->getQuery()
            ->getResult();
    }
}