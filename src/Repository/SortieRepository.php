<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\s;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findByFilter($campus, $nom, $debut, $fin, $orga, $etat, $inscrit, $nonInscrit): array
    {
        $query = $this->createQueryBuilder('s')
            ->select('s', 'p', 'e', 'ps')
            ->join('s.participants', 'ps')
            ->join('s.organisateur', 'p')
            ->join('s.etat', 'e')
            ->andWhere('s.campus = :campus')
            ->andWhere('s.nom LIKE :nom')
            ->andWhere('s.dateHeureDebut > :debut')
            ->andWhere('s.dateHeureDebut < :fin')
            ->setParameter('campus', $campus)
            ->setParameter('nom', "%" . $nom . "%")
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->orderBy('s.nom', 'ASC');

        if ($orga!==0){
            $query->andWhere('s.organisateur = :orga')
                ->setParameter('orga', $orga);
        }

        if ($etat!=0){
            $query->andWhere('s.etat = :etat')
                ->setParameter('etat', $etat);
        }

        if ($inscrit!==null && $nonInscrit!==null){
            $query->andWhere('(s IN (:inscrit)')
                ->orWhere('s NOT IN (:nonInscrit))')
                ->setParameter('inscrit', $inscrit)
                ->setParameter('nonInscrit', $nonInscrit);
        } elseif ($inscrit!==null){
            $query->andWhere('s IN (:inscrit)')
                ->setParameter('inscrit', $inscrit);
        } elseif ($nonInscrit!==null){
            $query->andWhere('s NOT IN (:nonInscrit)')
                ->setParameter('nonInscrit', $nonInscrit);
        }

        $query = $query->getQuery();

        return $query->getResult();
    }

    public function findAllSortie(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'p', 'e', 'ps')
            ->join('s.participants', 'ps')
            ->join('s.organisateur', 'p')
            ->join('s.etat', 'e')
            ->getQuery()
            ->getResult();
    }
}
