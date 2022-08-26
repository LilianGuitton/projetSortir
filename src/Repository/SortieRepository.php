<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        if ($orga!==0) {
            if ($etat!==0) {
                if ($inscrit!==null){
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('s.etat = :etat')
                            ->andWhere('(s IN (:inscrit)')
                            ->orWhere('s NOT IN (:nonInscrit))')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('etat', $etat)
                            ->setParameter('inscrit', $inscrit)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('s.etat = :etat')
                            ->andWhere('s IN (:inscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('etat', $etat)
                            ->setParameter('inscrit', $inscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                } else {
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('s.etat = :etat')
                            ->andWhere('s NOT IN (:nonInscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('etat', $etat)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('s.etat = :etat')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('etat', $etat)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                }
            } else {
                if ($inscrit!==null){
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('(s IN (:inscrit)')
                            ->orWhere('s NOT IN (:nonInscrit))')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('inscrit', $inscrit)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('s IN (:inscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('inscrit', $inscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                } else {
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->andWhere('s NOT IN (:nonInscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.organisateur = :orga')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('orga', $orga)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                }
            }
        } else {
            if ($etat!==0){
                if ($inscrit!==null){
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.etat = :etat')
                            ->andWhere('(s IN (:inscrit)')
                            ->orWhere('s NOT IN (:nonInscrit))')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('etat', $etat)
                            ->setParameter('inscrit', $inscrit)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.etat = :etat')
                            ->andWhere('s IN (:inscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('etat', $etat)
                            ->setParameter('inscrit', $inscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                } else {
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.etat = :etat')
                            ->andWhere('s NOT IN (:nonInscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('etat', $etat)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s.etat = :etat')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('etat', $etat)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                }
            } else {
                if ($inscrit!==null){
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('(s IN (:inscrit)')
                            ->orWhere('s NOT IN (:nonInscrit))')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('inscrit', $inscrit)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s IN (:inscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('inscrit', $inscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                } else {
                    if ($nonInscrit!==null){
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->andWhere('s NOT IN (:nonInscrit)')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->setParameter('nonInscrit', $nonInscrit)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    } else {
                        return $this->createQueryBuilder('s')
                            ->select('s')
                            ->andWhere('s.campus = :campus')
                            ->andWhere('s.nom LIKE :nom')
                            ->andWhere('s.dateHeureDebut > :debut')
                            ->andWhere('s.dateHeureDebut < :fin')
                            ->setParameter('campus', $campus)
                            ->setParameter('nom', "%" . $nom . "%")
                            ->setParameter('debut', $debut)
                            ->setParameter('fin', $fin)
                            ->orderBy('s.id', 'ASC')
                            ->getQuery()
                            ->getResult();
                    }
                }
            }
        }
    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
