<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Category[] Returns an array of category filtered on user
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('d')
        ->andWhere('d.createdBy = :val')
        ->setParameter('val', $user->getId())
        ->orderBy('d.id', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }

    /**
     * @return array Returns an array of depense filtered on family's users
     */
    public function findByFamily(User $user): array
    {
        $output = [];
        $family = $user->getFamily();

        if($family === null)
            return $this->findByUser($user);

        $members = $family->getMembers();

        if($members === null)
            return $this->findByUser($user);

        foreach ($members as $member) {
            foreach ($this->findByUser($member) as $category) {
                $output[] = $category;
            }
        }

        return $output;
    }
    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
