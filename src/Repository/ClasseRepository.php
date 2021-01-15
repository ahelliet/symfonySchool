<?php

namespace App\Repository;

use App\Entity\Classe;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Classe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classe[]    findAll()
 * @method Classe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    /**
     * @return $nbEleves Retourne toutes les classes avec le nombre d'élèves et la moyenne de chaque classe
     */
    public function findAllWithNombreElevesAndMoyenne()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.eleves', 'e')
            ->select('c.id, c.nom, count(e.id) as nombreEleves, sum(e.moyenne)/count(e.id) as moyenneDeClasse')
            ->where('c.id = e.classe')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return $nbEleves Retourne toutes les classes avec le nombre d'élèves et la moyenne de chaque classe
     */
    public function FindMoyenneDeClasse(int $id)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.eleves', 'e')
            ->select('sum(e.moyenne)/count(e.id) as moyenneDeClasse')
            ->where('c.id = e.classe')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->groupBy('c.id')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countClasses()
    {
        return $this->createQueryBuilder("c")
        ->select("COUNT(c.id)")
        ->getQuery()
        ->getSingleScalarResult();
    }

    // /**
    //  * @return Classe[] Returns an array of Classe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Classe
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
