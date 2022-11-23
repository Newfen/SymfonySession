<?php

namespace App\Repository;

use App\Entity\StagiaireSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StagiaireSession>
 *
 * @method StagiaireSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method StagiaireSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method StagiaireSession[]    findAll()
 * @method StagiaireSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StagiaireSession::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(StagiaireSession $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(StagiaireSession $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    /**
//     * @return StagiaireSession[] Returns an array of StagiaireSession objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StagiaireSession
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
