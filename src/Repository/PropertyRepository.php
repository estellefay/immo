<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    
    /**
     * @return Property[]
     */
    public function findAllVisible(): array
    {
        return $this->createQueryBuilder()
            ->where('p.rented = false')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Property[]
     */
    public function findLastest() 
    {
        return $this->findVisibleQuery()
            ->where('p.rented = false')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }


    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
        ->where('p.rented = false');
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
