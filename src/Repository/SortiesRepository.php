<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Particpant;
use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{


    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Sorties::class);
        $this->paginator = $paginator;
    }


    /**
     * Récupère les sorties en lien avec une recherche
     * @param SearchData $search
     * @param Particpant $currentUser
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search, Particpant $currentUser): PaginationInterface
    {
        $date = new \DateTime('now');
        $date->sub(new \DateInterval('P1M'));

        $query = $this
            ->createQueryBuilder('s')
            ->select('c', 's', 'e')
            ->join('s.site', 'c')
            ->join('s.etat', 'e')
            ->andWhere('e.libelle != (:etat) ')
            ->setParameter('etat', 'creee')
            ->andWhere('s.dateHeureDebut > (:date)')
            ->setParameter('date',$date)
        ;

        if (!empty($search->q)){
            $query = $query
                ->andWhere('s.nomSortie LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->site)){
            $query = $query
                ->andWhere('c.id = (:site)')
                ->setParameter('site', $search->site);
        }
        if ($search->organiser == true){
            $query = $query
                ->andWhere('s.organisateur = (:user)')
                ->setParameter('user', $currentUser);
        }
        if ($search->inscrit == true && $search->pasInscrit == true){

        } else {
            if ($search->inscrit == true){
                $query = $query
                    ->addSelect('i')
                    ->join('s.inscriptions', 'i')
                    ->andWhere('i.participants = :user')
                    ->setParameter('user', $currentUser)
                ;
            }
            if ($search->pasInscrit == true){
                $query = $query
                    ->addSelect('i')
                    ->leftJoin('s.inscriptions', 'i')
                   ->andWhere('i.participants is null OR i.participants != (:user)')
                    ->setParameter('user', $currentUser)
                ;
            }
        }
        if ($search->passee == true){
            $query = $query
                ->andWhere('e.libelle = (:libelle)')
                ->setParameter('libelle', 'passee');
        }
        if ($search->dateDebut !== null){
            $query = $query
                ->andWhere('s.dateHeureDebut > = (:dateHeureDebut)')
                ->setParameter('dateHeureDebut', $search->dateDebut);
        }
        if ($search->dateFin !== null){
            $query = $query
                ->andWhere('s.dateLimiteInscription < = (:date_limite_inscription)')
                ->setParameter('date_limite_inscription', $search->dateFin);
        }


        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            10
        );
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
            ->where('s.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
