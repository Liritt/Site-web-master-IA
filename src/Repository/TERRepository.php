<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Entity\TER;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TER>
 *
 * @method TER|null find($id, $lockMode = null, $lockVersion = null)
 * @method TER|null findOneBy(array $criteria, array $orderBy = null)
 * @method TER[]    findAll()
 * @method TER[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TERRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TER::class);
    }

    public function save(TER $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TER $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(string $researchText = '')
    {
        return $this->createQueryBuilder('t')
            ->where('t.title LIKE :searchText')
            ->orderBy('t.date')
            ->setParameter('searchText', '%'.$researchText.'%')
            ->getQuery()
            ->execute();
    }

    public function searchTeacherTERS(Teacher $teacher = null)
    {
        $id = $teacher->getId();

        return $this->createQueryBuilder('ter')
            ->join('ter.teacher', 'teacher')
            ->addSelect('teacher')
            ->where('teacher.id LIKE :id')
            ->orderBy('ter.date')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    public function searchTERById(int $id)
    {
        return $this->createQueryBuilder('ter')
            ->where('ter.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()[0];
    }

    public function findWithTeacher(int $id): ?TER
    {
        return $this->createQueryBuilder('ter')
            ->addSelect('teach as teacher')
            ->leftJoin('ter.teacher', 'teach')
            ->where('ter.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult()[0];
    }

//    /**
//     * @return TER[] Returns an array of TER objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TER
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
