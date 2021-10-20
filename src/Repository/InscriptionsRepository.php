<?php

namespace App\Repository;

use App\Entity\Inscriptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscriptions[]    findAll()
 * @method Inscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscriptions::class);
    }

    /**
//<<<<<<< HEAD
//
//
//=======
//>>>>>>> 3b66985dae850e6cf687bdac8f330563fafdb162
//     * @return Inscriptions[] Returns an array of Inscriptions objects
//     */
//
//    public function findAllwithSortie()
//    {
//        return $this->createQueryBuilder('i')
//            ->join('i.sortie', 's')
//            ->addSelect('COUNT(s)')
//            ->groupBy('s.id')
//            ->getQuery()
//            ->getResult();
//    }

    /**
     * @return Inscriptions[] Returns an array of Inscriptions objects
     */

    public function findAllParticipantswithSortie($id)
    {
        return $this->createQueryBuilder('i')
            ->join('i.sortie', 's')
            ->join('i.participants', 'p')
            ->addSelect('s')
            ->addSelect('p')
            //->groupBy('s.id')
            ->where('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        //->getScalarResult();
    }

//
//     /**
//      * @return Inscriptions[] Returns an array of Inscriptions objects
//      */
//
//
//    public function findAllwithSortie()

    /**
     * @return Inscriptions[] Returns an array of Inscriptions objects
     */

    public function findAllwithParticipant()

    {
        return $this->createQueryBuilder('i')
            ->join('i.participants', 'p')
            ->addSelect('p')
            ->groupBy('i.sortie')
            ->getQuery()
            ->getResult();
        //->getScalarResult();
    }


//    /**
//     * @return Inscriptions[] Returns an array of Inscriptions objects
//     */
//
//    public function findAllwithParticipant()
//    {
//        return $this->createQueryBuilder('i')
//            ->join('i.participants_no_participant', 'p')
//            ->addSelect('p')
//            ->groupBy('i.sortie')
//            ->getQuery()
//            ->getResult();
//        //->getScalarResult();
//    }

    /**
     * @return Inscriptions[] Returns an array of Inscriptions objects
     */

    public function findAllSortieByParticipant($id)
    {
        return $this->createQueryBuilder('i')
            ->join('i.sortie', 's')
            ->join('i.participants', 'p')
            ->addSelect('s')
            ->addSelect('p')
            ->where('p.id = :id')
            ->groupBy('s.id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        //->getScalarResult();
    }



    /*
    public function findOneBySomeField($value): ?Inscriptions
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
