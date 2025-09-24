<?php

namespace App\Repository;

use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Depense>
 */
class DepenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depense::class);
    }

    private function QueryBuilderOrderByCreatedFilteredOnIdCreatedBy(int $idUser): QueryBuilder
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdBy = :val')
            ->setParameter('val', $idUser)
            ->orderBy('d.created', 'DESC');
    }

    public function sumAmountOfUserDepense(User $user): float
    {
        $result = $this->createQueryBuilder('dep')
            ->select('SUM(dep.amount) AS depense_amount')
            ->andWhere('dep.createdBy = :val')
            ->setParameter('val', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    /**
     * @return Depense[] Returns an array of depense filtered on user
     */
    public function findByUser(User $user): array
    {
        return $this->QueryBuilderOrderByCreatedFilteredOnIdCreatedBy($user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findByUserWithPagination(User $user): Pagerfanta
    {
        $query = $this->QueryBuilderOrderByCreatedFilteredOnIdCreatedBy($user->getId())
            ->setMaxResults(10)
            ->getQuery();

        return new Pagerfanta(new QueryAdapter($query));
    }


    /**
     * @return Depense[] Returns an array of depense filtered on user month and year
     */
    public function findByUserByYearByMonth(User $user, int $month, int $year): array
    {
        $dateStart = new \DateTimeImmutable();
        $dateStart = $dateStart->setDate($year, $month, 1);

        $interval = new \DateInterval('P1M');

        $dateEnd = $dateStart->Add($interval);

        return $this->createQueryBuilder('d')
            ->andWhere('d.created >= :start and d.created < :end and d.createdBy = :usr')
            ->setParameter('start', $dateStart)
            ->setParameter('end', $dateEnd)
            ->setParameter('usr', $user)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByRangeYear(string $dateStart, string $dateEnd, User $user): array
    {
        $formattedStartDate = \DateTimeImmutable::createFromFormat('Y-m-d', $dateStart);
        $formattedEndDate = \DateTimeImmutable::createFromFormat('Y-m-d', $dateEnd);

        return $this->createQueryBuilder('d')
            ->andWhere('d.created >= :start and d.created < :end and d.createdBy = :usr')
            ->setParameter('start', $formattedStartDate)
            ->setParameter('end', $formattedEndDate)
            ->setParameter('usr', $user)
            ->orderBy('d.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByYear(int $year): array
    {
        $dateStart = new \DateTimeImmutable();
        $dateStart = $dateStart->setDate($year, 1, 1);
        $interval = new \DateInterval('P1Y');
        $dateEnd = $dateStart->Add($interval);

        return $this->createQueryBuilder('d')
            ->andWhere('d.created >= :start and d.created < :end')
            ->setParameter('start', $dateStart)
            ->setParameter('end', $dateEnd)
            ->orderBy('d.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUserByYear(User $user, int $year): array
    {
        $dateStart = new \DateTimeImmutable();
        $dateStart = $dateStart->setDate($year, 1, 1);
        $interval = new \DateInterval('P1Y');
        $dateEnd = $dateStart->Add($interval);

        return $this->createQueryBuilder('d')
            ->andWhere('d.created >= :start and d.created < :end and d.createdBy = :usr')
            ->setParameter('start', $dateStart)
            ->setParameter('end', $dateEnd)
            ->setParameter('usr', $user)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Depense[] Returns an array of depense filtered on family's users
     */
    public function findByFamily(User $user): array
    {
        $output = [];
        $family = $user->getFamily();

        if (!isset($family)) {
            /*
             * @todo : manage error
             */
            return [];
        }

        $members = $family->getMembers();

        foreach ($members as $member) {
            foreach ($this->findByUser($member) as $depense) {
                $output[] = $depense;
            }
        }

        return $output;
    }

    //    /**
    //     * @return Depense[] Returns an array of Depense objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Depense
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
