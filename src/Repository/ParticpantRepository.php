<?php

namespace App\Repository;

use App\Entity\Particpant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Particpant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Particpant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Particpant[]    findAll()
 * @method Particpant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticpantRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Particpant::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Particpant) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Particpant[] Returns an array of Particpant objects
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


    public function findOneById($value): ?Particpant
    {
        return $this->createQueryBuilder('p')
            ->join('p.site', 's')
            ->addSelect('s')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Particpant[] Returns an array of Particpant objects
     */

    public function findSortieById($value)
    {
        return $this->createQueryBuilder('p')
            ->join('p.inscriptions', 'i')
            ->join('i.sortie', 's')
            ->addSelect('i')
            ->addSelect('s')
            ->Where('p.id = :val')
            ->setParameter('val', $value)
            //->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }
}
