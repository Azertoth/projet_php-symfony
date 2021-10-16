<?php

namespace App\Repository;

use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     * @return Sorties[] Returns an array of Sorties objects
     */

    public function findAllSortiesWithLieuxAndVilles($value)
    {
        return $this->createQueryBuilder('s')
            ->join('s.lieux', 'l')
            ->addSelect('l')
            ->join('l.ville', 'v')
            ->addSelect('v')
            ->getQuery()
            ->getResult();
    }



    public function findOneById($value): ?Sorties
    {
        return $this->createQueryBuilder('s')
            ->join('s.lieux', 'l')
            ->addSelect('l')
            ->join('l.ville', 'v')
            ->addSelect('v')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
